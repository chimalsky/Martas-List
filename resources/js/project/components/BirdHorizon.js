import { useEffect, useState } from "react";
import { Cell, ScatterChart, Scatter, XAxis, YAxis, Tooltip, ResponsiveContainer, ZAxis } from 'recharts';

export function BirdHorizon({chrono}) {
    const [birds, setBirds] = useState([]);

    useEffect(() => {
        // Get bird data and set it to loadedBirds
        fetch(`/project/digital-object/birdring/fetch?chrono=${chrono}`)
            .then(res => res.json())
            .then(json => {
                const items = [];
                for (let index in json) {
                    items.push(json[index]);
                }
               
                setBirds(items);
            });
    }, [chrono]);

    const parseDomain = () => [
        0,
        Math.max(
        Math.max.apply(
            null,
            birds.map((entry) => entry.bodymass),
        ),
        Math.max.apply(
            null,
            birds.map((entry) => entry.bodymass),
        ),
        ),
    ];
    const range = [60, 120];
    const colors = ['red', 'blue', 'green', 'yellow']

    const getArrivingBirds = () => birds.filter(b => b.migratoryStatus === 'arriving')
        .map(b => { return {...b, x: Math.random() * 10, y: Math.random() * 300 } });
    const getDepartingBirds = () => birds.filter(b => b.migratoryStatus === 'departing')
        .map(b => { return {...b, x: Math.random() * 10, y: Math.random() * 300 } });
    const getRemainingBirds = () => birds.filter(b => b.migratoryStatus === null)
        .map(b => { return {...b, x: Math.random() * 10, y: Math.random() * 300 } });

    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            return <div className="bg-white text-xs p-4">
                <p className="label">{payload[0].payload.name}</p>
                <p className="intro">{payload[2].name}: {payload[2].value} g</p>
                <p className="intro">appearance: {payload[0].payload.appearance}</p>
            </div>;
        }
        
        return null;
    };

    const customFill = bird => {
        console.log(bird)
        const dict = {
            'Common': '#544B32',
            'Uncommon': '#847653',
            'Rare': '#D7D1C4'
        };
        console.log(dict[bird.appearance])
        return dict[bird.appearance] ?? 'pink';
    }
        
    return <>
        <div style={{transform: 'translateY(-120px)', width: "33%", height: "80%"}}>
            <ResponsiveContainer width="100%" height="100%">
                <ScatterChart margin={styles.scatterMargin}>
                    <XAxis type="number" dataKey="x" hide />
                    <YAxis type="number" dataKey="y" hide />
                    <ZAxis type="number" dataKey="bodymass" unit="g" domain={parseDomain()} range={range} />
                    <Tooltip content={CustomTooltip} cursor={{ strokeDasharray: '3 3' }} />
                    <Scatter name="A dool" data={getDepartingBirds()}>
                        {getDepartingBirds().map(departing => {
                            <Cell key={`cell-${departing.id}`} fill={customFill(departing)} />
                        })}
                    </Scatter>
                    <Scatter name="A bool" data={getArrivingBirds()}>
                        {getArrivingBirds().map(arriving => (
                            <Cell key={`cell-${arriving.id}`} fill={customFill(arriving)} />
                        ))}
                    </Scatter>
                </ScatterChart>
            </ResponsiveContainer>
        </div>
      
        <div style={{width: "33%", height: "100%"}}>
            <ResponsiveContainer width="100%" height="100%">
                    <ScatterChart margin={styles.scatterMargin}>
                        <XAxis type="number" dataKey="x" hide />
                        <YAxis type="number" dataKey="y" hide />
                        <ZAxis type="number" dataKey="bodymass" unit="g" domain={parseDomain()} range={range} />
                        <Tooltip content={CustomTooltip} cursor={{ strokeDasharray: '3 3' }} />
                        <Scatter name="A bool" data={getRemainingBirds()}>
                            {getRemainingBirds().map(remaining => (
                                <Cell key={`cell-${remaining.id}`} fill={customFill(remaining)} />
                            ))}
                        </Scatter>
                    </ScatterChart>
            </ResponsiveContainer>
        </div>

        <div style={{transform: 'translateY(-120px)', width: "33%", height: "80%"}}>
            <ResponsiveContainer width="100%" height="100%">
                <ScatterChart margin={styles.scatterMargin}>
                    <XAxis type="number" dataKey="x" hide />
                    <YAxis type="number" dataKey="y" hide />
                    <ZAxis type="number" dataKey="bodymass" unit="g" domain={parseDomain()} range={range} />
                    <Tooltip content={CustomTooltip} cursor={{ strokeDasharray: '3 3' }} />
                    <Scatter name="A bool" data={getDepartingBirds()}>
                        {getDepartingBirds().map(departing => (
                            <Cell key={`cell-${departing.id}`} fill={customFill(departing)} />
                        ))}
                    </Scatter>
                </ScatterChart>
            </ResponsiveContainer>
        </div>
    </>
}

const styles = {
    scatterMargin: {
        top: 4,
        right: 4,
        bottom: 4,
        left: 4,
    }
};