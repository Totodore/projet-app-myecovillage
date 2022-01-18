export class ProgressService {

	/**
	 * @param {HTMLProgressElement} _progressElement
	 */
	_progressElement;

	/**
	 * @param {boolean} _showing
	 */
	_showing = false;

	constructor() {
		this._progressElement = document.querySelector("header .progressbar");
		if (!this._progressElement)
			throw new Error("Progress element not found");
	}

	show() {
		if (!this._showing) {
			this._showing = true;
			this._progressElement.classList.add("show");
		}
	}

	hide() {
		if (this._showing) {
			this._showing = false;
			this._progressElement.classList.remove("show");
		}
	}
}