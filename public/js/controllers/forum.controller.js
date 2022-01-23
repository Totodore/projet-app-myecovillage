import { BaseController } from "../core/base.controller.js";
import { ApiService } from "../services/api.service.js";

export class ForumController extends BaseController {
  id = "forum";

  /**
   * @param {ApiService} apiService
   */
  constructor(params, apiService) {
    super("forum", params);
    this.apiService = apiService;
  }

  async onInit() {
    for (const question of this.selectAll(".forum-wrapper")) {
      if (!question.querySelector(".questions")) continue;
      question
        .querySelector(".questions")
        .addEventListener("click", () => question.classList.toggle("expand"));
    }
    this.select("#ask-form").addEventListener("submit", (e) =>
      this.submitNewForumPost(e)
    );
    this.selectAll("#answer-form").forEach((form) =>
      form.addEventListener("submit", (e) => this.submitAnswer(e))
    );
  }

  /**
   * @param {Event} event
   */
  async submitNewForumPost(e) {
    e.preventDefault();
    const form = e.target;
    const data = Object.fromEntries(new FormData(form).entries());
    try {
      const response = await this.apiService.post("/api/forum/add", data);
      this.navigate("/forum");
    } catch (e) {
      console.error(e);
    }
  }

  /**
   * @param {Event} e
   */
  async submitAnswer(e) {
    e.preventDefault();
    const form = e.target;
    const data = Object.fromEntries(new FormData(form).entries());
    try {
      const response = await this.apiService.put("/api/forum/answer", data);
      this.navigate("/forum");
    } catch (e) {
      console.error(e);
    }
  }
}
