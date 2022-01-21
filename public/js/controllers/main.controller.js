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
		this.navigate("signup", '.inscription');
		this.navigate("account", '.account');
		this.navigate("signin", ".mobile-connexion");
		this.navigate("signup", ".mobile-inscription");
		this.navigate("account", ".mobile-account");
		this.navigate("minigame", ".mobile-game");
		this.navigate("minigame", ".game");
		this.navigate("contactus", ".mobile-contact");
		this.navigate("forum", ".mobile-forum");
		this.navigate("", '.home');
		this.navigate("", ".logo-link");
		this.navigate("", ".acceuil");
		this.navigate("faq", "#FAQ_f");
		this.navigate("contactus", "#contact");
		this.navigate("cgu", "#CGU");
		this.navigate("forum", ".forum");
		this.navigate("ticket", "#ticket");
		this.navigate("admin", "#admin");
		this.select("#user-input").addEventListener('input', e => this.onSearch(e.target.value));
		this.updateLoginStatus();
		this.select("#admin").style.display = this.apiService.logged && await this.apiService.isAdmin() ? 'block' : 'none';
		this.selectAll(".item").forEach(item => item.addEventListener("click", () => document.querySelector("#body-wrapper").click()));
	}

	/**
	 * @param {string} route
	 */
	onNavigate(route) {
		if (route[0] == "/signin" && !this.apiService.logged) {
			this.select(".connexion").style.display = "none";
			this.select(".mobile-connexion").style.display = "none";
			this.select(".inscription").style.display = "block";
			this.select(".mobile-inscription").style.display = "block";
		} else if (route[0] == "/signup" && !this.apiService.logged) {
			this.select(".connexion").style.display = "block";
			this.select(".mobile-connexion").style.display = "block";
			this.select(".inscription").style.display = "none";
			this.select(".mobile-inscription").style.display = "none";
		} else if (route[0] == "/" && !this.apiService.logged) {
			this.navigate("signin");
			this.select(".connexion").style.display = "block";
			this.select(".mobile-connexion").style.display = "block";
			this.select(".inscription").style.display = "block";
			this.select(".mobile-inscription").style.display = "block";
		}
		this.select(".search-user").style.display = this.apiService.logged ? 'flex' : 'none';
		this.select("#ticket").style.display = this.apiService.logged ? 'block' : 'none';
	}

	updateLoginStatus() {
		this.log("User logging state", this.apiService.logged);
		if (this.apiService.logged) {
			this.select(".account").style.display = "block";
			this.select(".mobile-account").style.display = "block";
			this.select(".connexion").style.display = "none";
			this.select(".mobile-connexion").style.display = "none";
			this.select(".inscription").style.display = "none";
			this.select(".mobile-inscription").style.display = "none";
		} else {
			this.select(".account").style.display = "none";
			this.select(".mobile-account").style.display = "none";
			this.select(".connexion").style.display = "block";
			this.select(".mobile-connexion").style.display = "block";
			this.select(".inscription").style.display = "block";
			this.select(".mobile-inscription").style.display = "block";
		}
	}

	async onSearch(query) {
		this.log('Searching for ' + query);

		if (query.length < 2) {
			this.select("#user-list").innerHTML = "";
			return;
		}

		const res = await this.apiService.get("/" + baseUrl + '/api/users/search?query=' + query);
		if (res && res.length > 0) {
			this.select('#user-list').innerHTML = '';
			for (const user of res) {
				const li = document.createElement('li');
				li.innerHTML = `<button id="user-search-${user.id}" data-id="${user.id}" href="/${baseUrl}/user?id=${user.id}">${user.firstname} ${user.name} | ${user.email}</butt>`;
				this.select('#user-list').appendChild(li);
				this.navigate(`user?id=${user.id}`, `#user-search-${user.id}`);
			}
		} else if (res && res.length == 0) {
			this.select('#user-list').innerHTML = '';
		}
	}
}