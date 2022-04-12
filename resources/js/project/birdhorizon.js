import { useEffect, useRef, useState } from "react";

const width = 800;
const height = 340;

const color = d3.scaleSequential().domain([1,20]).interpolator(d3.interpolateViridis);
const radiusScale = d3.scalePow()
    .exponent(0.5)
    .domain([0, 12000])
    .range([5, 12]);
const collideScale = d3.scalePow()
    .exponent(2)
    .domain([0, 12000])
    .range([5, 12]);
const chargeScale = d3.scalePow()
    .exponent(0.8)
    .domain([0, 12000])
    .range([1, 20]);

function centroid(nodes) {
    let x = 0;
    let y = 0;
    let z = 0;
    for (const d of nodes) {
        let k = d.r ** 2;
        x += d.x * k;
        y += d.y * k;
        z += k;
    }
    return {x: x / z, y: y / z};
}

function forceCluster() {
    const strength = 0.2;
    let nodes;
  
    function force(alpha) {
      const centroids = d3.rollup(nodes, centroid, d => d.data.group);
      const l = alpha * strength;
      for (const d of nodes) {
        const {x: cx, y: cy} = centroids.get(d.data.group);
        d.vx -= (d.x - cx) * l;
        d.vy -= (d.y - cy) * l;
      }
    }
  
    force.initialize = _ => nodes = _;
  
    return force;
}

const clusterCount = 3;
const clusters = new Array(clusterCount);
const migratoryStatusClusterDict = {
    'null': 0,
    'arriving': 1,
    'departing': 2
};
const clusterColorDict = ['red', 'orange', 'blue'];

function BirdHorizon({chrono}) {
    const canvasRef = useRef();
    const [loadedBirds, setLoadedBirds] = useState([]);
    let canvas;

    useEffect(() => {
        // Get bird data and set it to loadedBirds
        fetch(`/project/digital-object/birdring/fetch?chrono=${chrono}`)
            .then(res => res.json())
            .then(json => {
                const items = [];
                for (let index in json) {
                    items.push(json[index]);
                }
                setLoadedBirds(items);
            });
    }, [chrono]);

    useEffect(() => {
        const nodes = [];

        canvas = d3.select('#birdhorizon-svg');
        canvas.attr("width", width).attr("height", height);
        loadedBirds.forEach(e => {
            const migratoryStatus = e.migratoryStatus ?? 'null';
            const i = migratoryStatusClusterDict[migratoryStatus];
            const processed = {
                cluster: i,
                radius: radiusScale(e.bodymass),
                x: Math.cos(i / clusterCount * 2 * Math.PI) * 200 + width / 2 + Math.random(),
                y: Math.sin(i / clusterCount * 2 * Math.PI) * 200 + height / 2 + Math.random()
            };
            nodes.push(processed);
        });
    
        const simulation = d3
            .forceSimulation(nodes)
            .force("x", d3.forceX(width / 2).strength(1))
            .force("y", d3.forceY(height / 2).strength(1))
            .force('charge', d3.forceManyBody().strength(-100))
            .force("collision",d3
                .forceCollide()
                .radius(function(d) {
                    return d.radius;
                })
                .strength(0.2)
            );
    
        const node = canvas.selectAll('circle')
            .data(nodes, d => d.id)
            .join(
                enter => enter.append("circle")
                    .attr('id', d => d.id)
                    .attr('fill', d => clusterColorDict[d.cluster])
                    .transition().duration(3000)
                    .attr('r', d => d.radius)
                    .attr("cx", (d, i) => d.x /3)
                    .attr("cy", d => d.y /3),
                update => update
                    .transition().duration(3000)
                    .attr('fill', d => clusterColorDict[d.cluster]),
                exit => exit.transition().duration(750).remove()
            );
    
        simulation.on("tick", () => {
            node.attr("transform", d => `translate(${d.x + 1},${d.y + 1})`);
        });
    
        function tick(e) {
            node.each(cluster(10 * e.alpha * e.alpha))
                .attr("transform", function (d) {
                    var k = "translate(" + d.x + "," + d.y + ")";
                    return k;
                })
        }
    
        function cluster(alpha) {
            return function (d) {
                var cluster = clusters[d.cluster];
                if (cluster === d) return;
                var x = d.x - cluster.x,
                    y = d.y - cluster.y,
                    l = Math.sqrt(x * x + y * y),
                    r = d.radius + cluster.radius;
                if (l != r) {
                    l = (l - r) / l * alpha;
                    d.x -= x *= l;
                    d.y -= y *= l;
                    cluster.x += x;
                    cluster.y += y;
                }
            };
        }
            
    }, [chrono]);

    return  <div id="birdhorizon">
        <svg ref={canvasRef} id="birdhorizon-svg">
        </svg>
    </div>
}

export default BirdHorizon