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
		this.navigate("account", '.account');
		this.navigate("", '.home');
		this.navigate("", ".logo-link");
		this.navigate("", ".acceuil");
		this.navigate("faq", "#FAQ_f");
		this.navigate("contactus", "#contact");
		this.navigate("cgu", "#CGU");
		this.navigate("forum", ".forum");
		this.updateLoginStatus();
	}

	/**
	 * @param {string} route
	 */
	onNavigate(route) {
		if (route[0] == "/signin" && !this.apiService.logged) {
			this.select(".connexion").style.display = "none";
			this.select(".inscription").style.display = "block";
		} else if (route[0] == "/signup" && !this.apiService.logged) {
			this.select(".connexion").style.display = "block";
			this.select(".inscription").style.display = "none";
		} else if (route[0] == "/home" && !this.apiService.logged) {
			this.select(".connexion").style.display = "block";
			this.select(".inscription").style.display = "block";
		}
	}

	updateLoginStatus() {
		console.log(this.apiService.logged);
		if (this.apiService.logged) {
			this.select(".account").style.display = "block";
			this.select(".connexion").style.display = "none";
			this.select(".inscription").style.display = "none";
		} else {
			this.select(".account").style.display = "none";
			this.select(".connexion").style.display = "block";
			this.select(".inscription").style.display = "block";
		}
	}
}