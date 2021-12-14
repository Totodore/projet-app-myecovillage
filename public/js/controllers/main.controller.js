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

	onInit() {
		this.navigate("signin", '.connexion');
		this.navigate("signup", '.inscription');
		this.navigate("", '.home');
		this.navigate("", ".logo-link");
		this.navigate("", ".acceuil");
		this.navigate("faq", ".faq");
	}

	/**
	 * @param {string} route
	 */
	onNavigate(route) {
		if (route[0] == "/signin") {
			this.select(".connexion").style.display = "none";
			this.select(".inscription").style.display = "block";
		} else if (route[0] == "/signup") {
			this.select(".connexion").style.display = "block";
			this.select(".inscription").style.display = "none";
		}
	}
}