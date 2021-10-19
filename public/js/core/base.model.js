export class BaseModel {
	/**
	 * @param {Object} data
	 */
	constructor(data) {
		Object.assign(this, data);
	}
}