import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class HomeController extends BaseController {

    id = "home";

    /**
     * @param {ApiService} apiService
     */
    constructor(params, apiService) {
        super("home", params);
        this.apiService = apiService;
    }

    async onInit() {
        setTimeout(() => this.barAnimation(), 2000);

    }
    barAnimation() {
        const compteurs = document.querySelectorAll(".compteur");
        for (let compteur of compteurs) {
            let cpt = 0;
            const n = +compteur.getAttribute("data-value");
            const duree = 2;
            const delta = Math.ceil((duree * 1000) / n);

            function countdown() {
                compteur.innerHTML = ++cpt + "%";
                if (cpt < n) {
                    setTimeout(countdown, delta);
                }
            }
            countdown();

        }
    }
}