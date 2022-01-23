import { BaseController } from "../../core/base.controller.js";
import { ApiService } from "../../services/api.service.js";

export class AdminForumController extends BaseController {
  id = "admin/forum";

  /**
   * @param {ApiService} apiService
   */
  apiService;

  constructor(params, apiService) {
    super("admin/forum", params);
    this.apiService = apiService;

  }
	
  async onInit() {
		for (const forum of this.selectAll(".forum"))
			forum.querySelector("span.material-icons").addEventListener("click", () => this.removeEl(forum));
  }

	/**
	 * @param {HTMLElement} el 
	 */
	async removeEl(el) {
		const id = el.dataset.id;
		try {
			await this.apiService.delete("/api/forum/delete?id=" + id);
			this.navigate("admin/forum");
		} catch(e) {
			console.error(e);
		}
	}

}
