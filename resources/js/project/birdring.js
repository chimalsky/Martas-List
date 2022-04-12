import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import {data as chronoData} from './temporal-data.js';
import {getBirdsByChrono} from './birdring-data.js';
import AudioEmbed from './AudioEmbed.js';
import BirdHorizon from './BirdHorizon.js';

const chronoDict = [
    'january',
    'february',
    'march',
    'april',
    'may',
    'june',
    'july',
    'august',
    'september',
    'october',
    'november',
    'december'
];
    
const chronoContextDict = {
    month: 'month',
    season: 'season',
};

const BirdRing = function() {
    const [chrono, setChrono] = useState(chronoDict[0]);
    const [chronoContext, setChronoContext] = useState(chronoContextDict.month);
    const [isPlaying, setIsPlaying] = useState(false);

    const monthClicked = month => {
        setChrono(month);
    };

    useEffect(() => {
        if (!isPlaying) return;
        return;
        const interval = setInterval(() => {
            const literalNextIndex = chronoDict.findIndex(item => item === chrono);
            const nextChronoIndex = (literalNextIndex === (chronoDict.length - 1))
                ? 0
                : literalNextIndex+1;

            setChrono(chronoDict[nextChronoIndex]);
        }, 1000);
        return () => clearInterval(interval);
    }, [isPlaying]);

    return <div className="mt-12 mx-auto max-w-xl">
        {chronoDict.map(month => 
            <button key={month} onClick={() => monthClicked(month)} className="mx-10">
                {month}
            </button>
        )}
        
        <div className="font-bold my-12">
            {chrono}
        </div>

        <BirdHorizon chrono={chrono}/>

        <AudioEmbed chrono={chrono} />

        <div id="chrono-player" className="flex justify-center">
            <button onClick={() => setIsPlaying(true)}>
                Play
            </button>
            <button onClick={() => setIsPlaying(false)}>
                Pause
            </button>
        </div>
        <div className="mx-auto max-w-sm">
        </div>
        <section className="bg-yellow-300 p-24 mt-20">
            Notes
        </section>
    </div>;
};

ReactDOM.render(
    <React.StrictMode>
      <BirdRing />
    </React.StrictMode>,
    document.getElementById('birdring-wrapper')
);

const width = 900;
const height = 900;
const centerRadius = width / 18;
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
    .startAngle(d => {return d.x0})
    .endAngle(d => d.x1)
    .padAngle(d => Math.min((d.x1 - d.x0), 0.02))
    .padRadius(10)
    .innerRadius(d => d.y0 * (centerRadius * 1.5))
    .outerRadius(d => Math.max(d.y0 * (centerRadius * 1.5), d.y1 * (centerRadius * 1.5) - 1));

const arcVisible = d => { return d.y1 <= 3 && d.y0 >= 1 && d.x1 > d.x0 };

const labelVisible = d => {
    return d.y1 <= 3 && d.y0 >= 1 && (d.y1 - d.y0) * (d.x1 - d.x0) > 0.03;
};

const labelTransform = d => {
    const x = (d.x0 + d.x1) / 2 * 180 / Math.PI;
    const y = (d.y0 + d.y1) / 2 * (centerRadius * 1.5);
    return `rotate(${x - 90}) translate(${y},0) rotate(${x < 180 ? 0 : 180})`;
};

function birdring() {
    const root = partition(chronoData).each(d => d.current = d);
    console.log(root);
    
    const svg = d3.select('#birdring')
        .append("svg")
        .attr("viewBox", [0, 0, width, height])
        .attr('fill', 'white');

    const g = svg.append("g").attr("transform", `translate(${width*.5},${height*.3})`);

    const path = g.append("g")
        .selectAll("path")
        .data(root.descendants())
        .join(enter => {
            enter.append("path")
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
        });
        
    path.filter(d => d.children)
        .style("cursor", "pointer")
        .on("click", chronoSelected);

    const label = g.append("g")
        .attr("pointer-events", "none")
        .attr("text-anchor", "middle")
        .style("user-select", "none")
        .selectAll("text").data(root.descendants()).join(enter => 
            enter.append("text")
                .attr("dy", "0.35em")
                .attr('fill', '#333')
                .attr("fill-opacity", d => +labelVisible(d.current))
                .attr("transform", d => labelTransform(d.current))
                .style('text-transform', 'capitalize')
                .style('font-size', '28px')
                .text(d => d.data.name.slice(0, 3))
        );

    /*const center = g.append("circle")
        .datum(root)
        .attr("r", centerRadius)
        .attr("pointer-events", "all")
        .attr("text-anchor", "middle")
		.style("cursor", "pointer")
        .on("click", chronoSelected);*/

    function chronoSelected(event, p) {
        window.dispatchEvent(new CustomEvent("chronoSelected", {detail: p}));
        //center.datum(p.parent || root);
    
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
            //.attr("fill-opacity", d => arcVisible(d.target) ? (d.children ? 0.6 : 0.4) : 0)
            .attrTween("d", d => () => arc(d.current));
    
        label.filter(function(d) {
            return +this.getAttribute("fill-opacity") || labelVisible(d.target);
        }).transition(t)
            //.attr("fill-opacity", d => +labelVisible(d.target))
            //.attrTween("transform", d => () => labelTransform(d.current));
    }
}

document.addEventListener('turbolinks:load', () => {
    birdring();

    const selectedDatumEl = document.querySelector('#selectedDatum');
	const container = d3.select("#birdhorizon");
	const canvas = d3.select('#birdhorizoncanvas');
    const chronoPlayerPlayButton = document.querySelector('#play');
    const chronoPlayerPauseButton = document.querySelector('#pause');

	window.addEventListener('chronoSelected', ev => {
        selectedChrono = ev.detail.data.name;

		selectedDatumEl.innerHTML = selectedChrono;

		getBirdsByChrono(selectedChrono).then(res => res.json())
			.then(json => {
                //container.style('visibility', 'visible');
                const items = [];
                for (let index in json) {
                    items.push(json[index]);
                }
				birdhorizon(canvas, items);
			});
	});
});