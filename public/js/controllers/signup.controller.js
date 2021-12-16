import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class SignupController extends BaseController {

	id = "signup";
	ressourcePath = "signup";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("signup", params);
		this.apiService = apiService;
	}

	async onInit() {
		if (this.apiService.logged)
			this.navigate("")
		this.select("form").addEventListener("submit", e => this.onSubmitForm(e));
	}

	/**
	 * @param {Event} e
	 */
	async onSubmitForm(e) {
		e.preventDefault();
		if (!e.target.checkValidity())
			return;
		const data = Object.fromEntries(Array.from(this.selectAll("form input")).map(el => [el.getAttribute("name"), el.value]));
		if (data.repeatPassword !== data.password) {
			return;
		}
		const res = await this.apiService.register(data);
		this.log(res);
		this.navigate("signin");
	}
}