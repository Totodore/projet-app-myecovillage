import { BaseController } from "../../core/base.controller.js";

export class AdminUserController extends BaseController {

	id = "admin/user";

	constructor(params, apiService) {
		const query = location.search.length > 2 ? location.search.match(/(?<=query=)([^&])+/g)[0] : null;
		super("admin/user", { ...params, query });
		this.apiService = apiService;
	}

	async onInit() {
		this.select("input").addEventListener("input", e => this.onSearch(e));
		this.addListeners();
	}

	addListeners() {
		for (const user of this.selectAll(".user:not(.search-user-admin)")) {
			user.querySelector(".action-admin").addEventListener("click", e => this.onAdmin(user, e));
			user.querySelector(".action-delete").addEventListener("click", e => this.onDelete(user, e));
		}
	}

	/**
	 * @param {Event} e
	 */
	async onSearch(e) {
		e.preventDefault();
		let query = e.target.value;
		if (!query || query.length < 2)
			query = "";
		try {
			const res = await this.apiService.get("/" + baseUrl + "/api/users/search?query=" + query);
			this.render(res);
		} catch (e) {
			console.error(e);
		}

	}

	render(users) {
		this.selectAll(".user:not(.search-user-admin)").forEach(el => el.remove());
		this.select(".user-list").insertAdjacentHTML("beforeend", users.map(user => `
			<div class="user" data-id="${user.id}" data-isadmin="${user.isadmin}" data-name="${user.firstname + " " + user.name}">
				<div class="user-info">
					<div class="user-name">${user.firstname + " " + user.name}</div>
					<div class="user-email">${user.email}</div>
				</div>
				<div class="user-actions">
					<button class="action-admin">Administrateur <span class="material-icons">${user.isadmin ? 'done' : 'close' }</span></button>
					<button class="action-delete"><span class="material-icons">delete</span></button>
				</div>
			</div>
		`).join(""));
		this.addListeners();
	}

	/**
	 * @param {HTMLElement} user
	 * @param {Event} e
	 */
	async onAdmin(user, e) {
		e.preventDefault();

		try {
			const res = await this.apiService.post("/api/users/admin", { id: user.dataset.id, isadmin: !user.dataset.isadmin });
			user.dataset.isadmin = res.user.isadmin;
			user.querySelector(".action-admin .material-icons").textContent = res.user.isadmin ? "done" : "close";
		} catch(e) {
			console.error(e);
		}
	}

	/**
	 * @param {HTMLElement} user
	 * @param {Event} e
	 */
	async onDelete(user, e) {
		e.preventDefault();
		if (!confirm(`Voulez-vous vraiment supprimer l'utilisateur ${user.dataset.name} ?`))
			return;

		try {
			await this.apiService.delete("/api/users/delete?id=" + user.dataset.id);
			user.remove();
		} catch(e) {
			console.error(e);
		}
	}
}