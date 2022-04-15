import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import { AudioEmbed } from './components/AudioEmbed.js';
import { BirdHorizon } from './components/BirdHorizon.js';
import { BirdringChart } from './components/BirdringChart';

const chronoContextDict = ['month', 'season'];

const BirdRing = function() {
    const [chrono, setChrono] = useState('january');
    const [chronoContext, setChronoContext] = useState(chronoContextDict[0]);

    return <div className="mx-auto max-w-4xl">
        <header className="max-w-sm mx-auto h-96">
            <BirdringChart chrono={chrono} setChrono={setChrono} setChronoContext={setChronoContext} />
        </header>

        <div className="max-w-full h-80">
            <BirdHorizon chrono={chrono} />
        </div>

        <div id="chrono-player" className="flex justify-center border-t border-gray-600 pt-2 mb-2">
            <button className="w-6 h-6" onClick={() => setIsPlaying(true)}>
                <img src="/img/play.png" />
            </button>
            <button className="w-8 h-8" onClick={() => setIsPlaying(false)}>
                <img src="/img/pause.png" />
            </button>
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