export const getBirdsByChrono = chrono => {
	return fetch(`/project/digital-object/birdring/fetch?chrono=${chrono}`);
}