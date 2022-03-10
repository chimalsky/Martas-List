import {data as chronoData} from './temporal-data.js';
import {getBirdsByChrono} from './birdring-data.js';
import birdhorizon from './birdhorizon.js';

const width = 1200;
const radius = width / 8;
let loopActivated = false;
let selectedChrono;
const months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
const getSelectedChronoIndex = () => {
    return months.findIndex(m =>  m === selectedChrono);
}

const partition = () => {
    const root = d3.hierarchy(chronoData)
        .sum(d => d.value)
        .sort((a, b) => b.value - a.value);
    return d3.partition().size([2 * Math.PI, root.height + 1])(root);
};

const color = d3.scaleOrdinal(d3.quantize(d3.interpolateRainbow, chronoData.children.length + 1));

const arc = d3.arc()
    .startAngle(d => d.x0)
    .endAngle(d => d.x1)
    .padAngle(d => Math.min((d.x1 - d.x0) / 2, 0.039))
    .padRadius(radius * .25)
    .innerRadius(d => d.y0 * (radius * 1.25))
    .outerRadius(d => Math.max(d.y0 * (radius * 1.25), d.y1 * (radius * 1.25) - 1));

const arcVisible = d => { return d.y1 <= 3 && d.y0 >= 1 && d.x1 > d.x0 };

const labelVisible = d => {
    return d.y1 <= 3 && d.y0 >= 1 && (d.y1 - d.y0) * (d.x1 - d.x0) > 0.03;
};

const labelTransform = d => {
    const x = (d.x0 + d.x1) / 2 * 180 / Math.PI;
    const y = (d.y0 + d.y1) / 2 * (radius * 1.25);
    return `rotate(${x - 90}) translate(${y},0) rotate(${x < 180 ? 0 : 180})`;
};

const format = d3.format(",d");

function birdring() {
    const root = partition(chronoData);
    root.each(d => d.current = d);

    const svg = d3.select('#birdring')
        .append("svg")
        .attr("viewBox", [0, 0, width, width])
        .attr('fill', 'white')
        .style("font", "12px sans-serif");

    const g = svg.append("g").attr("transform", `translate(${width / 2},${width / 2})`);

    const path = g.append("g")
        .selectAll("path")
        .data(root.descendants().slice(1))
        .join("path")
            .style("cursor", "pointer")
            .attr("data-chrono", d => d.data.name)
            .attr("fill", d => { while (d.depth > 1) d = d.parent; return color(d.data.name); })
            .attr("fill-opacity", d => arcVisible(d.current) ? (d.children ? 0.6 : 0.4) : 0)
            .attr("d", d => arc(d.current))
			.on('mouseover', function(d, i) {
				const el = d3.select(this);
				el.attr('original-fill', el.attr('fill'))
				el.attr('fill', 'orange');
			})
			.on('mouseout', function(d, i) {
				const el = d3.select(this);
				el.attr('fill', el.attr('original-fill'));
			})
            .on("click", chronoSelected);
        
    path.filter(d => d.children)
        .style("cursor", "pointer")
        .on("click", chronoSelected);

    path.append("title")
        .text(d => `${d.ancestors().map(d => d.data.name).reverse().join("/")}\n${format(d.value)}`);

    const label = g.append("g")
        .attr("pointer-events", "none")
        .attr("text-anchor", "middle")
        .style("user-select", "none")
        .selectAll("text").data(root.descendants().slice(1)).join("text")
            .attr("dy", "0.35em")
            .attr('fill', '#333')
            .attr("fill-opacity", d => +labelVisible(d.current))
            .attr("transform", d => labelTransform(d.current))
            .style('text-transform', 'capitalize')
            .text(d => d.data.name);

    const center = g.append("circle")
        .datum(root)
        .attr("r", radius * 1.25)
        .attr("pointer-events", "all")
        .attr("text-anchor", "middle")
		.style("cursor", "pointer")
        .on("click", chronoSelected)
		.append('g')
			.append('text')
			.text('foo')
			.attr('dx', -20)
			.attr('fill', 'black');

    function chronoSelected(event, p) {
        window.dispatchEvent(new CustomEvent("chronoSelected", {detail: p}));
        center.datum(p.parent || root);
    
        root.each(d => d.target = {
            x0: Math.max(0, Math.min(1, (d.x0 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
            x1: Math.max(0, Math.min(1, (d.x1 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
            y0: Math.max(0, d.y0 - p.depth),
            y1: Math.max(0, d.y1 - p.depth)
        });
    
        const t = g.transition().duration(700);

        if (p.depth === 0) {
            showBirds(t);
        }
        if (p.depth === 1) {
            showBirds(t);
			showBackYear();
        }
    }

    function showBirds(t) {
        // Transition the data on all arcs, even the ones that aren’t visible,
        // so that if this transition is interrupted, entering arcs will start
        // the next transition from the desired position.
        path.transition(t)
            .tween("data", d => {
            	const i = d3.interpolate(d.current, d.target);
                return t => d.current = i(t);
            })
            .filter(function(d) {
                return +this.getAttribute("fill-opacity") || arcVisible(d.target);
            })
            .attr("fill-opacity", d => arcVisible(d.target) ? (d.children ? 0.6 : 0.4) : 0)
            .attrTween("d", d => () => arc(d.current));
    
        label.filter(function(d) {
                return +this.getAttribute("fill-opacity") || labelVisible(d.target);
            }).transition(t)
            .attr("fill-opacity", d => +labelVisible(d.target))
            .attrTween("transform", d => () => labelTransform(d.current));
    }

	function showBackYear() {
		center.select('text')
			.attr('opacity', 1);
	}
}

document.addEventListener('turbolinks:load', () => {
    let foo;

    birdring();

	const selectedDatumEl = document.querySelector('#selectedDatum');
	const container = d3.select("#birdhorizon");
	const canvas = document.querySelector('#birdhorizoncanvas');
    const chronoPlayerPlayButton = document.querySelector('#play');
    const chronoPlayerPauseButton = document.querySelector('#pause');

	window.addEventListener('chronoSelected', ev => {
        selectedChrono = ev.detail.data.name;
        container.style('visibility', 'hidden');

		selectedDatumEl.innerHTML = selectedChrono;

		getBirdsByChrono(selectedChrono).then(res => res.json())
			.then(json => {
                container.style('visibility', 'visible');
				foo = birdhorizon(container, canvas, json, selectedChrono);
			});
	});

    const loop = () => {
        if (!loopActivated) return;
        let activeIndex = selectedChrono 
            ? ((getSelectedChronoIndex() === 11) ? 0 : getSelectedChronoIndex() + 1 )
            : 0;
        const monthInvoker = document.querySelector(`[data-chrono=${months[activeIndex]}`);
        monthInvoker.dispatchEvent(new Event('click'));
        const nextIndex = (activeIndex === 11) ? 0 : activeIndex+1;
    }
    let looper;

    chronoPlayerPlayButton.addEventListener('click', startLoopingMonths);
    chronoPlayerPauseButton.addEventListener('click', stopLoopingMonths);

    function startLoopingMonths() {
        loopActivated = true;  
        chronoPlayerPlayButton.style.display = 'none';
        chronoPlayerPauseButton.style.display = 'block';
        loop();
        looper = setInterval(loop, 1500);
    }

    function stopLoopingMonths() {
        loopActivated = false;
        chronoPlayerPauseButton.style.display = 'none';
        chronoPlayerPlayButton.style.display = 'block';
        clearInterval(looper);
    }
})