import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import { AudioEmbed } from './components/AudioEmbed.js';
import { BirdHorizon } from './components/BirdHorizon.js';
import { BirdringChart, monthDict, seasonDict } from './components/BirdringChart';

const chronoContextDict = ['month', 'season'];

const BirdRing = function() {
    const [chrono, setChrono] = useState('january');
    const [chronoContext, setChronoContext] = useState(chronoContextDict[0]);
    const [isPlaying, setIsPlaying] = useState(false);

    useEffect(() => {
        if (!isPlaying) return;

        const shiftToNextChrono = () => {
            const chronoDict = chronoContext === chronoContextDict[0] ? monthDict : seasonDict;
            const currentChronoIndex = chronoDict.findIndex(month => month.name === chrono);
            const nextChrono = (currentChronoIndex === 0) 
                ? chronoDict[chronoDict.length - 1] 
                : chronoDict[currentChronoIndex - 1];
            setChrono(prev => nextChrono.name);
        }

        const timer = setInterval(shiftToNextChrono, 2000);
        return () => clearInterval(timer);
    }, [isPlaying, chrono]);

    return <div className="mx-auto max-w-4xl">
        <header className="max-w-sm mx-auto" style={{height: '364px'}}>
            <BirdringChart chrono={chrono} setChrono={setChrono} setChronoContext={setChronoContext} />
        </header>

        <div id="chrono-player" className="flex justify-center mb-2">
            {isPlaying ?
                <button className="w-8 h-8" onClick={() => setIsPlaying(false)}>
                    <img src="/img/pause.png" />
                </button> 
                :
                <button onClick={() => setIsPlaying(true)}>
                    <img src="/img/play.png" className="w-6 h-6" /> 
                </button>
            }
        </div>

        <div className="max-w-full flex flex-wrap" style={{height: 500}}>
            <BirdHorizon chrono={chrono} />
        </div>

        <AudioEmbed chrono={chrono} />
    </div>;
};

ReactDOM.render(
    <React.StrictMode>
      <BirdRing />
    </React.StrictMode>,
    document.getElementById('birdring-wrapper')
);