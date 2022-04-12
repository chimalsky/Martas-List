const width = 900;
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

function forceCollide() {
    const alpha = 0.4; // fixed for greater rigidity!
    const padding1 = 2; // separation between same-color nodes
    const padding2 = 6; // separation between different-color nodes
    let nodes;
    let maxRadius;
  
    function force() {
      const quadtree = d3.quadtree(nodes, d => d.x, d => d.y);
      for (const d of nodes) {
        console.log(d)
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

export default function birdhorizon(canvas, data) {
    console.log(canvas, data)
    canvas.attr("width", width).attr("height", height);
    const clusterCount = 3;
    const clusters = new Array(clusterCount);
    const nodes = [];
    const migratoryStatusClusterDict = {
        'null': 0,
        'arriving': 1,
        'departing': 2
    };
    const clusterColorDict = ['red', 'orange', 'blue'];
    
    data.forEach(e => {
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
        
    /*function ticked() {
        canvas
            .selectAll('circle')
            .data(nodes, d => d.id)
            .join(
                enter => enter,
                update => update
                    .attr('fill', 'blue')
                    .attr("cx", function(d) { return d.x; })
                    .attr("cy", function(d) { return d.y; }),
            )
    }*/
}