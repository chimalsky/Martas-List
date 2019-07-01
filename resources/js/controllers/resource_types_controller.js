import { Controller } from "stimulus"
import axios from 'axios'

export default class extends Controller {   
    static targets = ['results']
    
    select(ev) {
        let query = ev.target.value

        axios.get(this.data.get('search-url'), {params: {type: query}})
            .then((response) => {
                let html = response.data
                this.resultsTarget.innerHTML = html
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function () {
                // always executed
            });
    }
}