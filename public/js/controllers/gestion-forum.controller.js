import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class GestionForumController extends BaseController {

	id = "gestion_forum";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("gestion_forum", params);
		this.apiService = apiService;
	}

	async onInit() {
		const questions = document.querySelectorAll('.forum-fle');
		for (const question of questions) {
            question.querySelector('.expand_more').addEventListener('click', () => {
                const reponse = question.querySelector('.réponse');
                if (reponse.style.display == 'block')
                    reponse.style.display = 'none';
                else reponse.style.display = 'block';
            });
        }
	}
}