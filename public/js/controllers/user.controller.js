import { BaseController } from "../core/base.controller.js";

export class UserController extends BaseController {

	id = "user";

	constructor(params) {
		const userId = location.search.match(/(?<=id=)([^&])+/g)[0];
		super("user", {...params, id: userId});
	}

	async onInit() {
	}
}