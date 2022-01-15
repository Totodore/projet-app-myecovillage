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
		const questions = document.querySelectorAll('.questions');
		for (const question of questions) {
            question.querySelector('span.material-icons').addEventListener('click', () => {
                const reponse = question.querySelector('.réponse');
                if (reponse.style.display == 'block')
                    reponse.style.display = 'none';
                else reponse.style.display = 'block';
            });
        }
	}
}