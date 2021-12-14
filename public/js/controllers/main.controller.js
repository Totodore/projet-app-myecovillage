import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class MainController extends BaseController {

    id = "index";
    ressourcePath = "/";

    /**
     * @param {ApiService} apiService
     */
    constructor(params, apiService) {
        super("/", params);
        this.apiService = apiService;
    }

    async onInit() {
        this.navigate("signin", '.connexion');
        this.navigate("signin", '#navconnexion');
        this.navigate("signup", '.inscription');
        this.navigate("signup", '#navinscription');
        this.navigate("", '.home');
        this.navigate("", ".logo-link");
        this.navigate("", ".acceuil");
    }
}