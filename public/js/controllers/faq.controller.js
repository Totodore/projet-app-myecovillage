import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class FaqController extends BaseController {

	id = "faq";
	ressourcePath = "faq";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("faq", params);
		this.apiService = apiService;
	}

	async onInit() {
        const questions = document.querySelectorAll('.questions');
        for (const question of questions) {
            question.querySelector('span.material-icons').addEventListener('click', () => {
                const panel = question.querySelector('.toggle-panel');
                if (panel.style.display == 'block')
                    panel.style.display = 'none';
                else panel.style.display = 'block';
            });
        }
		this.navigate("", ".test");
	}
}