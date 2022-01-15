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
		const question = document.querySelectorAll('.forum-wrapper');
		for (const questions of question) {
            questions.querySelector('span.material-icons').addEventListener('click', () => {
                const reponse = questions.querySelector('.reponse');
                if (reponse.style.display == 'block')
                    reponse.style.display = 'none';
                else reponse.style.display = 'block';
            });
        }
	}
}