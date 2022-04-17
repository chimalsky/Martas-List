import React from 'react';
import { PieChart, Pie, Cell, Label, LabelList, ResponsiveContainer } from 'recharts';

export const monthDict = [
    {name: 'january', shortName: 'jan', value: 1, fill: '#B7CBD8'},
    {name: 'february', shortName: 'feb', value: 1, fill: '#B7CBD8'},
    {name: 'march', shortName: 'mar', value: 1, fill: '#D2ACAE'},
    {name: 'april', shortName: 'apr', value: 1, fill: '#D2ACAE'},
    {name: 'may', shortName: 'may', value: 1, fill: '#D2ACAE'},
    {name:'june', shortName: 'jun', value: 1, fill: '#CFD8C6'},
    {name:'july', shortName: 'jul', value: 1, fill: '#CFD8C6'},
    {name:'august', shortName: 'aug', value: 1, fill: '#CFD8C6'},
    {name:'september', shortName: 'sep', value: 1, fill: '#E3B388'},
    {name:'october', shortName: 'oct', value: 1, fill: '#E3B388'},
    {name: 'november', shortName: 'nov', value: 1, fill: '#E3B388'},
    {name: 'december', shortName: 'dec', value: 1, fill: '#B7CBD8'}
].reverse();

export const seasonDict = [
    {name: 'winter', value: 1, fill: '#638193'},
    {name: 'spring', value: 1, fill: '#A56265'},
    {name: 'summer', value: 1, fill: '#6D7F5C'},
    {name: 'fall', value: 1, fill: '#B05E24'},
].reverse();

export function BirdringChart({setChronoContext, setChrono}) {
    return <ResponsiveContainer width="100%" height="100%">
        <PieChart>
            <Pie data={[{name: '19th Century', value: 1}]} 
            dataKey="value" innerRadius={0} outerRadius={35}
            paddingAngle={0}>
                <Cell key={`cell-century`} style={{fill: '#fff'}} />
                <LabelList dataKey="name" position="center" style={{fontSize: '11px', stroke: '#666'}} />
            </Pie>

            <Pie data={seasonDict} 
            startAngle={-180}
            dataKey="value" 
            innerRadius={35} outerRadius={90}>
                {seasonDict.map((season, index) => (
                    <Cell key={`cell-${index}`} fill={season.fill} style={styles.cell} onClick={() => {setChronoContext('season'); setChrono(season.name);} } />
                ))}
                <LabelList dataKey="name" position='inside' style={{fontFamily: 'Alegreya SC', fontSize: '10px', fontWeight:400, letterSpacing: 3, textTransform: 'uppercase', stroke: 'white'}} />
            </Pie>

            <Pie data={monthDict}
            startAngle={-210}
            innerRadius={90} outerRadius={158}
            paddingAngle={2.4}
            dataKey="value">
                {monthDict.map((month, index) => (
                    <Cell key={`cell-${index}`} fill={month.fill} style={styles.cell} onClick={() => {setChronoContext('month'); setChrono(month.name);} } />
                ))}
                <LabelList dataKey="shortName" style={{textTransform: 'capitalize'}} />
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