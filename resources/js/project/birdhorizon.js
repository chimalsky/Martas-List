export default function birdhorizon(container, canvas, data) {
    let width = 740;
    let height = 300;
    canvas.width = width;
    canvas.height = height;

    const context = canvas.getContext("2d");
    container.attr("width", width).attr("height", height);

    const dataArray = [];
    for(var i in data) {
        console.log(data[i]);
        dataArray.push([i, data[i]]);
    }

    const color = d3.scaleSequential().domain([1,10]).interpolator(d3.interpolateViridis);
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
        .range([5, 24]);
    const chargeScale = d3.scalePow()
        .exponent(0.8)
        .domain([0, 12000])
        .range([1, 12]);
    /*
    const points = container
        .selectAll("circle")
        .data(dataArray)
        .join("circle")
            .attr("cx", function(d) {
                const bird = d[1];
                let foo = width * .5;
                if (bird.migratoryStatus === 'arriving') {
                    foo = width * .2;
                } else if (bird.migratoryStatus === 'departing') {
                    foo = width * .8;
                }
                return foo;
            })
            .attr("cy", function(d, i) {return y(i)})
            .attr("r", 4);
    */
   /*
    const simulation = d3.forceSimulation(nodes)
        .alphaTarget(0.3) // stay hot
        .velocityDecay(0.1) // low friction
        .force("x", d3.forceX().strength(0.0001))
        .force("y", d3.forceY().strength(0.0001))
        .force("charge", d3.forceManyBody().strength(-2))
        .force("center", d3.forceCenter(width/12, height/12))
        .on("tick", ticked);*/

    const simulation = d3.forceSimulation(nodes)
        .alphaTarget(0.1) // stay hot
        .velocityDecay(0.05) // low friction
        .force("x", d3.forceX().strength(0.000001))
        .force("y", d3.forceY().strength(0.0002))
        .force("collide", d3.forceCollide().radius(d => {
            return radiusScale(getDatum(d).bodymass) * 2;
        }).iterations(1))
        .force("charge", d3.forceManyBody().strength(d => {
            return chargeScale(getDatum(d).bodymass);
        }))
        .on("tick", ticked);
    
    /*d3.select(canvas)
        .on("touchmove", (event) => event.preventDefault())
        .on("pointermove", pointed);*/
        
    function pointed(event) {
        const [x, y] = d3.pointer(event);
        nodes[0].fx = x - width / 2;
        nodes[0].fy = y - height / 2;
    }

    function ticked() {
        context.clearRect(0, 0, width, height);
        context.save();
        context.translate(width / 2, height / 2);
        for (const d of nodes) {
            const datum = getDatum(d);
            const scaledRadius = radiusScale(Number(datum.bodymass));
            context.beginPath();
            context.moveTo(d.x + scaledRadius, d.y);
            context.arc(d.x, d.y, scaledRadius, 0, 2 * Math.PI);
            context.fillStyle = (() => {
                // purple
                let foo = 1;
                if (datum.migratoryStatus === 'departing') {
                    // green
                    foo = 8;
                } else if (datum.migratoryStatus === 'arriving') {
                    // white
                    foo = 10;
                }
                return color(foo);
            })();
            context.fill();
        }
        context.restore();
    }

    function getDatum(node) {
        return dataArray[node.index][1];
    }
}