import { useEffect, useState } from "react";
import { ScatterChart, Scatter, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';

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
      const centroids = d3.rollup(nodes, centroid, d => d.cluster);
      const l = alpha * strength;
      for (const d of nodes) {
        const {x: cx, y: cy} = centroids.get(d.cluster);
        d.vx -= (d.x - cx) * l;
        d.vy -= (d.y - cy) * l;
      }
    }
  
    force.initialize = _ => nodes = _;
  
    return force;
}

function forceCollide() {
    const alpha = 0.4; // fixed for greater rigidity!
    const padding1 = 2; // separation between same-color nodes
    const padding2 = 6; // separation between different-color nodes
    let nodes;
    let maxRadius;
  
    function force() {
      const quadtree = d3.quadtree(nodes, d => d.x, d => d.y);
      for (const d of nodes) {
        const r = d.r + maxRadius;
        const nx1 = d.x - r, ny1 = d.y - r;
        const nx2 = d.x + r, ny2 = d.y + r;
        quadtree.visit((q, x1, y1, x2, y2) => {
          if (!q.length) do {
            if (q.data !== d) {
              const r = d.r + q.data.r + (d.data.group === q.data.data.group ? padding1 : padding2);
              let x = d.x - q.data.x, y = d.y - q.data.y, l = Math.hypot(x, y);
              if (l < r) {
                l = (l - r) / l * alpha;
                d.x -= x *= l, d.y -= y *= l;
                q.data.x += x, q.data.y += y;
              }
            }
          } while (q = q.next);
          return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
        });
      }
    }
  
    force.initialize = _ => maxRadius = d3.max(nodes = _, d => d.r) + Math.max(padding1, padding2);
  
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
const fillDict = {
    'departing': 'red',
    'arriving': 'green',
    'null': 'yellow'
};

export function BirdHorizon({chrono}) {
    const [departingBirds, setDepartingBirds] = useState([]);
    const [arrivingBirds, setArrivingBirds] = useState([]);
    const [remainingBirds, setRemainingBirds] = useState([]);

    useEffect(() => {
        // Get bird data and set it to loadedBirds
        fetch(`/project/digital-object/birdring/fetch?chrono=${chrono}`)
            .then(res => res.json())
            .then(json => {
                const items = [];
                for (let index in json) {
                    items.push(json[index]);
                }
                const arriving = items.filter(b => b.migratoryStatus === 'arriving'),
                      departing = items.filter(b => b.migratoryStatus === 'departing'),
                      remaining = items.filter(b => b.migratoryStatus === null);

                setArrivingBirds(arriving)//.map(b => { return {...b, x: Math.random() * 10, y: Math.random() * 300 } }));
                setDepartingBirds(departing)//.map(b => { return {...b, x: Math.random() * 50, y: Math.random() * 300 } }));
                setRemainingBirds(remaining)//.map(b => { return {...b, x: Math.random() * 120, y: Math.random() * 300 } }));
            });
    }, [chrono]);

    return <>
        {arrivingBirds.length} - {departingBirds.length} - {remainingBirds.length}
    </>
}