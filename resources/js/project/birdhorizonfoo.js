export default function birdhorizon(container, canvas, data) {
    let width = 900;
    let height = 240;
    canvas.width = width;
    canvas.height = height;

    const context = canvas.getContext("2d");
    container.attr("width", width).attr("height", height);

    const dataArray = [];
    for(var i in data) {
        dataArray.push([i, data[i]]);
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
        .range([5, 12]);
    const chargeScale = d3.scalePow()
        .exponent(0.8)
        .domain([0, 12000])
        .range([1, 30]);

    const simulation = d3.forceSimulation(nodes)
        .alphaTarget(0.1) // stay hot
        .velocityDecay(0.05) // low friction
        .force("x", d3.forceX().strength(0.000000001))
        .force("y", d3.forceY().strength(0.02))
        .force("collide", d3.forceCollide().radius(d => {
            return radiusScale(getDatum(d).bodymass) * 2.75;
        }).iterations(1))
        .force("charge", d3.forceManyBody().strength(d => {
            return chargeScale(getDatum(d).bodymass);
        }))
        .on("tick", ticked);
        
    function pointed(event) {
        const [x, y] = d3.pointer(event);
        nodes[0].fx = x - width / 2;
        nodes[0].fy = y - height / 2;
    }

    function ticked() {
        context.clearRect(0, 0, width, height);
        context.save();
        context.translate(width*.5, height*.5);
        for (const d of nodes) {
            const datum = getDatum(d);
            const scaledRadius = radiusScale(Number(datum.bodymass));
            context.beginPath();
            context.moveTo(d.x + scaledRadius, d.y);
            context.arc(d.x, d.y, scaledRadius, 0, 99 * Math.PI);
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
}