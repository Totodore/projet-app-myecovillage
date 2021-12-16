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
			const req = await this.post("api/auth/login", { email, password });
			const res = await req.json();
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

	async get(url, params) {
		const req = await fetch(url, { params: params, headers: this.token ? { "Authorization": "Bearer " + this.token } : null });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	async post(url, data) {
		const req = await fetch(baseUrl + url, { method: "POST", body: JSON.stringify(data), headers: { "Content-Type": "application/json", "Authorization": this.token ? "Bearer " + this.token : null } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	async put(url, data) {
		const req = await fetch(baseUrl + url, { method: "PUT", body: JSON.stringify(data), headers: { "Content-Type": "application/json", "Authorization": this.token ? "Bearer " + this.token : null } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	async delete(url) {
		const req = await fetch(baseUrl + url, { method: "DELETE", headers: { "Authorization": this.token ? "Bearer " + this.token : null } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
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