import React from 'react';
import { PieChart, Pie, Cell, LabelList, ResponsiveContainer } from 'recharts';

const monthDict = [
    {name: 'january', value: 1, fill: '#B7CBD8'},
    {name: 'february', value: 1, fill: '#B7CBD8'},
    {name: 'march', value: 1, fill: '#D2ACAE'},
    {name: 'april', value: 1, fill: '#D2ACAE'},
    {name: 'may', value: 1, fill: '#D2ACAE'},
    {name:'june', value: 1, fill: '#CFD8C6'},
    {name:'july', value: 1, fill: '#CFD8C6'},
    {name:'august', value: 1, fill: '#CFD8C6'},
    {name:'september', value: 1, fill: '#E3B388'},
    {name:'october', value: 1, fill: '#E3B388'},
    {name: 'november', value: 1, fill: '#E3B388'},
    {name: 'december', value: 1, fill: '#B7CBD8'}
].reverse();

const seasonDict = [
    {name: 'winter', value: 1, fill: '#638193'},
    {name: 'spring', value: 1, fill: '#A56265'},
    {name: 'summer', value: 1, fill: '#6D7F5C'},
    {name: 'fall', value: 1, fill: '#B05E24'},
].reverse();


const renderCustomizedLabel = props => {
    const { cx, cy, width, height, value } = props;
    const radius = 10;
    return <g>
        <circle cx={cx} cy={cy - radius} r={radius} fill="#8884d8" />
        <text x={cx + width / 2} y={cy - radius} fill="#fff" textAnchor="middle" dominantBaseline="middle">
            {value.split(' ')[1]}
        </text>
    </g>;
};

export function BirdringChart({setChronoContext, setChrono}) {
    return <ResponsiveContainer width="100%" height="100%">
        <PieChart>
            <Pie data={seasonDict} 
            startAngle={-180}
            dataKey="value" 
            innerRadius={45} outerRadius={90}>
                {seasonDict.map((season, index) => (
                    <Cell key={`cell-${index}`} fill={season.fill} style={styles.cell} onClick={() => {setChronoContext('season'); setChrono(season.name);} } />
                ))}
                <LabelList dataKey="name" position="top" />
            </Pie>

            <Pie data={monthDict}
            startAngle={-210}
            innerRadius={90} outerRadius={165}
            paddingAngle={.25}
            dataKey="value">
                {monthDict.map((month, index) => (
                    <Cell key={`cell-${index}`} fill={month.fill} style={styles.cell} onClick={() => {setChronoContext('month'); setChrono(month.name);} } />
                ))}
                <LabelList dataKey="name" position="top" />
            </Pie>
        </PieChart>
    </ResponsiveContainer>;
}

const styles = {
    cell: {
        cursor: 'pointer'
    },
    selectedCell: {
        fontWeight: '700'
    }
}