const audioEndpointDict = {
    march: '1207927645',
    july: '1229912158',
};

export function AudioEmbed({chrono}) {
    const apiEndpoint = audioEndpointDict[chrono];
    let apiUrl = undefined;

    if (apiEndpoint)
        apiUrl = `https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/${apiEndpoint}&color=%23ffffff&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true`;
    
    const soundcloudEmbed = <iframe width="100%" height="80" scrolling="no" frameBorder="no" allow="autoplay" src={apiUrl}></iframe>;
    
    return (apiEndpoint) 
        ? soundcloudEmbed 
        : <div className="mx-auto text-center text-2xl capitalize">{chrono} Sound coming soon</div>;
}