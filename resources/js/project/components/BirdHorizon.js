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
    const range = [60, 200];
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
                <p className="font-semibold">{payload[0].payload.name}</p>
                <p className="mb-1">Appearance: {payload[0].payload.appearance}</p>
                <p className="mb-1 capitalize">Migratory Status: {payload[0].payload.migratoryStatus ?? "Remaining"}</p>
                <p className="mb-1">Bodymass: {payload[2].value} g</p>
            </div>;
        }
        
        return null;
    };

    const customFill = bird => {
        const dict = {
            'Common': '#544B32',
            'Uncommon': '#847653',
            'Rare': '#D7D1C4'
        };
        return dict[bird.appearance] ?? 'pink';
    }
        
    return <>
        <div style={{transform: 'translateY(-120px) rotate(-14deg)', width: "33%", height: "80%"}}>
            <ResponsiveContainer width="100%" height="100%">
                <ScatterChart margin={styles.scatterMargin}>
                    <XAxis type="number" dataKey="x" hide />
                    <YAxis type="number" dataKey="y" hide />
                    <ZAxis type="number" dataKey="bodymass" unit="g" domain={parseDomain()} range={range} />
                    <Tooltip content={CustomTooltip} cursor={{ stroke: '0' }} />
                    <Scatter name="A bool" data={getArrivingBirds()} animationDuration={500}>
                        {getArrivingBirds().map(arriving => (
                            <Cell key={`cell-${arriving.id}`} fill={customFill(arriving)} style={{cursor: 'pointer'}}
                            onClick={(ev) => {
                                window.open(`/project/birds/${ev.target.id}`, '_blank');
                            }} />
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
                        <Tooltip content={CustomTooltip} cursor={{ stroke: '0' }} />
                        <Scatter name="A bool" data={getRemainingBirds()} animationDuration={500}>
                            {getRemainingBirds().map(remaining => (
                                <Cell key={`cell-${remaining.id}`} fill={customFill(remaining)} style={{cursor: 'pointer'}}
                                onClick={(ev) => {
                                    window.open(`/project/birds/${ev.target.id}`, '_blank');
                                }} />
                            ))}
                        </Scatter>
                    </ScatterChart>
            </ResponsiveContainer>
        </div>

        <div style={{transform: 'translateY(-120px) rotate(14deg)', width: "33%", height: "80%"}}>
            <ResponsiveContainer width="100%" height="100%">
                <ScatterChart margin={styles.scatterMargin}>
                    <XAxis type="number" dataKey="x" hide />
                    <YAxis type="number" dataKey="y" hide />
                    <ZAxis type="number" dataKey="bodymass" unit="g" domain={parseDomain()} range={range} />
                    <Tooltip content={CustomTooltip} cursor={{ stroke: '0' }} />
                    <Scatter name="A bool" data={getDepartingBirds()} animationDuration={500}>
                        {getDepartingBirds().map(departing => (
                            <Cell key={`cell-${departing.id}`} fill={customFill(departing)} style={{cursor: 'pointer'}}
                            onClick={(ev) => {
                                window.open(`/project/birds/${ev.target.id}`, '_blank');
                            }} />
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