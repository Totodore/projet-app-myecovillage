import { ProgressService } from "./progress.service.js";

export class ApiService {


	/**
	 * @param {ApiService} instance
	 */
	static instance;


	/**
	 * @param {ProgressService} progress
	 */
	static progress;

	constructor() {
		ApiService.instance = this;
		ApiService.progress = new ProgressService();
	}
	/**
	 * @param {string} username 
	 * @param {string} password
	 * @return {Promise<boolean>} 
	 */
	async login(email, password) {
		try {
			const res = await this.post("/api/auth/login", { email, password });
			console.log("login", res);
			if (!res.token)
				throw new Error("Invalid token");
			this.token = res.token;
			return true;
		} catch (e) {
			console.error(e);
			throw e;
		}
	}

	async register(data) {
		try {
			return await this.post("/api/auth/register", data);
		} catch (e) {
			console.error(e);
		}
	}

	async isAdmin() {
		return (await this.get("/" + baseUrl + "/api/auth/is-admin")).isAdmin;
	}

	logout() {
		localStorage.removeItem("token");
	}

	async get(url, showProgress = true) {
		if(showProgress)
			this.progress.show();
		try {
			const req = await fetch(url, { headers: this.token ? { "Authorization": this.token, Dynamic: true } : { Dynamic: true } });
			if (!req.ok) {
				throw new Error(req.status + " " + req.statusText);
			}
			return await req.json();
		} finally {
			if (showProgress)
				this.progress.hide();
		}
	}

	async post(url, data) {
		this.progress.show();
		try {
			const req = await fetch("/" + baseUrl + url, { method: "POST", body: JSON.stringify(data), headers: { "Content-Type": "application/json", "Authorization": this.token ? this.token : null, Dynamic: true } });
			if (!req.ok) {
				throw new Error(req.status + " " + req.statusText);
			}
			return await req.json();
		} finally {
			this.progress.hide();
		}
	}

	async put(url, data) {
		this.progress.show();
		try {
			const req = await fetch("/" + baseUrl + url, { method: "PUT", body: JSON.stringify(data), headers: { "Content-Type": "application/json", "Authorization": this.token ? this.token : null, Dynamic: true } });
			if (!req.ok) {
				throw new Error(req.status + " " + req.statusText);
			}
			return await req.json();
		} finally {
			this.progress.hide();
		}
	}

	async delete(url) {
		this.progress.show();
		try {
			const req = await fetch("/" + baseUrl + url, { method: "DELETE", headers: { "Authorization": this.token ? this.token : null, Dynamic: true } });
			if (!req.ok) {
				throw new Error(req.status + " " + req.statusText);
			}
			return await req.json();
		} finally {
			this.progress.hide();
		}
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

	/**
	 * @returns {ApiService}
	 */
	get progress() {
		return ApiService.progress;
	}
}