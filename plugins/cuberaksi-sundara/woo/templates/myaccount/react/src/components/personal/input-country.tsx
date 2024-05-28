import { AllCountries } from "@/helper";
import { countries_ } from "@/store";
import { getCodeList, getCodes } from "country-list";
import { useEffect, useRef, useState } from "react";
import Select, { SingleValue } from 'react-select';

interface Country {
	readonly value: string;
	readonly label: string;
	
}




export const SelectCountry = ({ field, value, setter }: { value: string, field: string, setter: (val: string) => void }) => {
	const [isClearable, setIsClearable] = useState(true);
	const [isSearchable, setIsSearchable] = useState(true);
	const [isDisabled, setIsDisabled] = useState(false);
	const [isLoading, setIsLoading] = useState(false);
	const [isRtl, setIsRtl] = useState(false);
	
	// console.log({ ctry: AllCountries() })

	const countries: readonly Country[] = countries_.getCountriesList() as Country[]
	// [
			
	// 	{ label: 'Brazil', value: 'BR' },
	// 	{ label: 'China', value: 'CN' },
	// 	{ label: 'Egypt', value: 'EG' },
	// 	{ label: 'France', value: 'FR' },
	// 	{ label: 'Germany', value: 'DE' },
	// 	{ label: 'Indonesian', value: 'ID' },
	// 	{ label: 'Japan', value: 'JP' },
	// 	{ label: 'Spain', value: 'ES' },
	// 	{ label: 'United States', value: 'US' },
	// 	{ label: 'Singapore', value: 'SG' }
	// ];

	
	const getDefaultValueFromValue = () => {
		const temp = countries.filter((country) => country.label === value)

		return temp[0]
	}
	
	const [selectedCountry, setSelectedCountry] = useState<Country | null>(getDefaultValueFromValue());
	
	const changeCountry = (val: SingleValue<Country>) => {
		if (val) {
			setSelectedCountry(val)
			setter(val.value)	
		}
		
	}

	useEffect(() => {
		// console.log(selectedCountry)
	}, [selectedCountry])

	

	return (
		<Select
			
			className="basic-single"
			classNamePrefix="select"
			onChange={(c) => changeCountry(c)}
			defaultValue={getDefaultValueFromValue()}
			isDisabled={isDisabled}
			isLoading={isLoading}
			isClearable={isClearable}
			isRtl={isRtl}
			isSearchable={isSearchable}
			name={field}
			options={countries}
		/>
	)	
}