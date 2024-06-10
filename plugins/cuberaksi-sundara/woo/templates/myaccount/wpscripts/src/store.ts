import { atom } from "jotai";
import { AllCountries } from "./helper";
import { getCode, getCodes, getName, getNames } from "country-list";
export const MenuItemConstant = {
	personal: 1,
	booking: 2,
	payment: 3,
	logout: 4
}
export const CurrentMenuItem = atom(MenuItemConstant.personal)


class Countries__ {
	// private raw: { [code:string]: string}

	constructor() {
		// this.raw = AllCountries()

	} 

	public getCountryName(code: string): string {
		return getName(code) as string
	}

	public getCountryCode(country: string) {
		return getCode(country) as string
	}

	public getCountriesList() {
		return getCodes().map((cty) => {
			return {
				label: getName(cty),
				value: cty.toUpperCase()
			}
		}).sort((a, b) => {
			let fa = (a.label as string).toLowerCase()
			let fb = (b.label as string).toLowerCase()

			if (fa < fb) {
				return -1;
			}
			if (fa > fb) {
				return 1;
			}
			return 0;
		})
	}
	

}
export const countries_ = new Countries__()