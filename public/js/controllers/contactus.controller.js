import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class ContactusController extends BaseController {

	ressourcePath = "contactus";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("contactus", params);
		this.apiService = apiService;
	}

	async onInit() {
        
         

	}
}