import {data as chronoData} from './temporal-data.js';
import {getBirdsByChrono} from './birdring-data.js';

const width = 1200;
const height = 460;
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
        .attr('fill', 'white');
        //.style("font", "12px sans-serif");

    const g = svg.append("g").attr("transform", `translate(${width*.5},${width*.5})`);

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

    const label = g.append("g")
        .attr("pointer-events", "none")
        .attr("text-anchor", "middle")
        .style("user-select", "none")
        .selectAll("text").data(root.descendants()).join("text")
            .attr("dy", "0.35em")
            .attr('fill', '#333')
            .attr("fill-opacity", d => +labelVisible(d.current))
            .attr("transform", d => labelTransform(d.current))
            .style('text-transform', 'capitalize')
            .style('font-size', '52px')
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

    const context = canvas.getContext("2d");
    container.attr("width", width).attr("height", height);
    canvas.width = width;
    canvas.height = height;

	window.addEventListener('chronoSelected', ev => {
        selectedChrono = ev.detail.data.name;
        container.style('visibility', 'hidden');

		selectedDatumEl.innerHTML = selectedChrono;

		getBirdsByChrono(selectedChrono).then(res => res.json())
			.then(json => {
                container.style('visibility', 'visible'); 
        
    const dataArray = [];
    for(var i in json) {
        dataArray.push([i, json[i]]);
    }

    const color = d3.scaleSequential().domain([1,20]).interpolator(d3.interpolateViridis);
    const nodes = dataArray.map(Object.create)
    const x = d3.scaleLinear()
        .domain([0, dataArray.length])
        .range([0, width]);
    const y = d3.scaleLinear()
        .domain([0, dataArray.length])
        .range([height, 0]);
    const radiusScale = d3.scalePow()
        .exponent(0.5)
        .domain([0, 12000])
        .range([5, 9]);
    const chargeScale = d3.scalePow()
        .exponent(0.8)
        .domain([0, 12000])
        .range([0, 8]);

    const simulation = d3.forceSimulation(nodes)
        //.alphaTarget(0.01) // stay hot
        //.velocityDecay(.06) // low friction
        .force("x", d3.forceX().strength(.002))
        .force("y", d3.forceY().strength(.003))
        .force("collide", d3.forceCollide().radius(d => {
            return radiusScale(getDatum(d).bodymass) * 3.2;
        }).iterations(20))
        .force("charge", d3.forceManyBody().strength(d => {
            return chargeScale(getDatum(d).bodymass);
        }))
        .on("tick", ticked);
        
    function pointed(event) {
        const [x, y] = d3.pointer(event);
        nodes[0].fx = x - width / 2;
        nodes[0].fy = y - height / 2;
    }

    function ticked(e) {
        console.log(e)
        context.save();
        context.clearRect(0, 0, width, height);
        context.translate(width*.5, height*.5);
        for (const d of nodes) {
            const datum = getDatum(d);
            const scaledRadius = radiusScale(Number(datum.bodymass));
            context.beginPath();
            context.moveTo(d.x + scaledRadius, d.y);
            context.arc(d.x, d.y, scaledRadius, 0, 2 * Math.PI);
            context.fillStyle = (() => {
                // purple
                let fill = 1;
                if (datum.appearance === 'Common') {
                    // green
                    fill = 10;
                } else if (datum.appearance === 'Uncommon') {
                    // lime
                    fill = 17;
                } else if (datum.appearance === 'Rare') {
                    // Yellow
                    fill = 20;
                }
                return color(fill);
            })();
            context.fill();
        }
        context.restore();
    }

    function getDatum(node) {
        return dataArray[node.index][1];
    }
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
        looper = setInterval(loop, 4500);
    }

    function stopLoopingMonths() {
        loopActivated = false;
        chronoPlayerPauseButton.style.display = 'none';
        chronoPlayerPlayButton.style.display = 'block';
        clearInterval(looper);
    }
})