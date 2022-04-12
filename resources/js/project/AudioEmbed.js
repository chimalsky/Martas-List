const audioEndpointDict = {
    march: '1207927645',
    july: '1229912158',
};

function AudioEmbed({chrono}) {
    const apiEndpoint = audioEndpointDict[chrono];
    let apiUrl = undefined;

    if (apiEndpoint)
        apiUrl = `https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/${apiEndpoint}&color=%23ffffff&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true`;
    
    return (apiEndpoint) ? <iframe width="100%" height="300" scrolling="no" frameBorder="no" allow="autoplay" 
        src={apiUrl}>
    </iframe> : <div className="mx-auto text-center text-2xl">{chrono} Sound coming soon</div>;
}

export default AudioEmbed;