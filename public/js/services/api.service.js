import { BaseService } from "../core/base.service.js";

export class ApiService extends BaseService {

	
	/**
	 * @param {ApiService} instance
	 */
	static instance;

	constructor() {
		super();
		ApiService.instance = this;
	}
	/**
	 * @param {string} username 
	 * @param {string} password
	 * @return {Promise<boolean>} 
	 */
	async login(email, password) {
		try {
			const res = await this.post("api/auth/login", { email, password });
			this.token = res.token;
			return true;
		} catch(e) {
			console.error(e);
			throw e;
		}
	}

	async register(data) {
		try {
			return await this.post("api/auth/register", data);
		} catch(e) {
			console.error(e);
		}
	}

	async get(url) {
		const req = await fetch(url, { headers: this.token ? { "Authorization": this.token } : null });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return await req.json();
	}

	async post(url, data) {
		const req = await fetch(baseUrl + url, { method: "POST", body: JSON.stringify(data), headers: { "Content-Type": "application/json", "Authorization": this.token ? this.token : null } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return await req.json();
	}

	async put(url, data) {
		const req = await fetch(baseUrl + url, { method: "PUT", body: JSON.stringify(data), headers: { "Content-Type": "application/json", "Authorization": this.token ? this.token : null } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return await req.json();
	}

	async delete(url) {
		const req = await fetch(baseUrl + url, { method: "DELETE", headers: { "Authorization": this.token ? this.token : null } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return await req.json();
	}

	set token(value) {
		return localStorage.setItem("token", value);
	}
	get token() {
		return localStorage.getItem("token");
	}

	get logged() {
		return !!this.token;
	}
}