export class BaseController {

	/**
	 * @type {object}
	 */
	params = {};
	id = "";
	constructor(params) {
		this.params = params;
		console.log("[Controller Creation] New " + this.constructor.name + " created");
	}
}