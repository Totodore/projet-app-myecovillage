import { BaseService } from "../core/base.service.js";

export class ApiService extends BaseService {

	/**
	 * @param {string} username 
	 * @param {string} password
	 * @return {Promise<boolean>} 
	 */
	async login(username, password) {
		try {
			const req = await this.post("/api/login", { username, password });
			const res = await req.json();
			this.token = res.token;
			return true;
		} catch(e) {
			console.error(e);
			return false;
		}
	}

	async register(data) {
		try {
			await this.post("/api/register", data);
		} catch(e) {
			console.error(e);
		}
	}

	async get(url, params) {
		const req = await fetch(baseUrl + url, { params: params });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	async post(url, data) {
		const req = await fetch(baseUrl + url, { method: "POST", body: JSON.stringify(data), headers: { "Content-Type": "application/json" } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	async put(url, data) {
		const req = await fetch(baseUrl + url, { method: "PUT", body: JSON.stringify(data), headers: { "Content-Type": "application/json" } });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	async delete(url) {
		const req = await fetch(baseUrl + url, { method: "DELETE" });
		if (!req.ok) {
			throw new Error(req.status + " " + req.statusText);
		}
		return req;
	}

	set token(value) {
		localStorage.setItem("token", value);
	}
	get token() {
		localStorage.getItem("token");
	}
}