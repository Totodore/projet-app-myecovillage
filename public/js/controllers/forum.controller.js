import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


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
		const questions = document.querySelectorAll('.forum-wrapper');
        for (const question of questions) {
            question.querySelector('span.material-icons').addEventListener('click', () => {
                const panel = question.querySelector('.reponse');
                if (panel.style.display == 'block')
                    panel.style.display = 'none';
                else panel.style.display = 'block';
            });
        }
	}
}