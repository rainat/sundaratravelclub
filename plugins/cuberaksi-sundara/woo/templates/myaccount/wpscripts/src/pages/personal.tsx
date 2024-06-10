import classNames from "classnames"
import { ChangeEvent, ReactNode, createRef, useEffect, useState } from "react"
import BookingContent from "./booking"
import { Input } from "@/components/ui/input"
import { SelectCountry } from "@/components/personal/input-country"
import clsx from "clsx"
import { useQuery, useQueryClient } from "@tanstack/react-query"
import { fetchAjaxWith, fetchUpdateAjaxWith } from "@/helper"
import { countries_ } from "@/store"

import { queryClient } from "@/App"
import { toast } from "sonner"


type ICard = {
	className: string,
	children: ReactNode
}

function Card({ className, children }: ICard) {
	return (
		<div className={classNames(className, "p-[28px] rounded-[20px] bordered border-[1px] border-color-[#C7C7C7]")}>
			{children}
		</div>)
}


const imgsrcdulu = 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/wong.png'

const initialpersonal = {
	first_name: '',
	last_name: '',
	billing_country: '',
	billing_phone: '',
	billing_city: '',
	billing_email: '',
	billing_address_1: ''

}

type IFileState = {
	file?: File | null | undefined,
	imageSrc?: string | null | undefined
}

export function Personal() {
	// console.log((window as any).sundara)
	
	const [values, setValues] = useState(initialpersonal)
	const profileQuery = useQuery({
		queryKey: ['userProfile'],
		// queryFn: () => fetch('http://localhost/cuberaksi/wp-json/sundara/v1/profile', { method: 'POST' }).then((res) => res.json()),
		queryFn: () => fetchAjaxWith('user_profile'),
		// select: (data) => { 
		// 	console.log({ data })
		// 	setValues(data)
		// 	return data
		// }
	})


	
	const [editMode, setEditMode] = useState(false)
	const [titleEdit, setTitleEdit] = useState('Edit')
	const [fileState, __setFileState] = useState<IFileState>({ file: null, imageSrc: imgsrcdulu })

	const setFileState = (state: IFileState, element: string) => {
		if (element === 'file') __setFileState({ ...fileState, file: state.file })
		if (element === 'image') __setFileState({ ...fileState, imageSrc: state.imageSrc })	
	}
	
	useEffect(() => {
		if (profileQuery.data) {

			// console.log({ profile: profileQuery.data })
			setValues(profileQuery.data)
		}

	}, [profileQuery.isSuccess])

	const editClick = () => {
		setEditMode(!editMode)
		if (!editMode) setTitleEdit('Update'); else setTitleEdit('Edit')

		if (editMode) {
			console.log({ values, fileState })
			fetchUpdateAjaxWith('user_profile', values).then((res) => res.json()).then(() => {
				toast.success('Updating...')
				queryClient.invalidateQueries({ queryKey: ['userProfile'] })

			})
				.catch((err) => {
					toast.error('update error')
				})
			
			
		}
		
		
	}

	const fileref = createRef<HTMLInputElement>()

	// useEffect(() => {
	// 	console.log({ countries: getNameList() })
	// }, [])
	//onChange={(e) => { e.preventDefault(); setValues({ ...values, [field]: e.currentTarget.value }) }} value={values[`${field}` as keyof typeof initialpersonal]} 
	//
	const InputText = ({ field }: { field: string }) => {
		const onChange = (e: ChangeEvent<HTMLInputElement>) => {
			e.preventDefault(); 
						 
			setValues({ ...values, [field]: e.target.value })
			// console.log(e.target.value, values)
		}
		return (<>
			{editMode ? <Input onChange={onChange} value={values[`${field}` as keyof typeof initialpersonal]} key={field} className="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" name={field} type="text" /> :
				<h6 className="text-[16px]">{values[`${field}` as keyof typeof initialpersonal]}</h6>
			} 
		</>
		)
	}

	//value={values[`${field}` as keyof typeof initialpersonal]} name={field} type="text" onChange={(e) => { e.preventDefault(); setValues({ ...values, [field]: e.target.value }) }}
	const InputAddress = ({ field }: { field: string }) => {
		
		return (<>
			{editMode ? <Input value={values[`${field}` as keyof typeof initialpersonal]} name={field} type="text" onChange={(e) => { e.preventDefault(); setValues({ ...values, [field]: e.target.value }) }} className="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" /> :
				<p className="mt-4 text-[14px]">{values[`${field}` as keyof typeof initialpersonal]}</p>
			} 
		</>
		)
	}

	const InputCountry = ({ field }: { field: string }) => {
		// console.log('neg', values[`${field}` as keyof typeof initialpersonal], countriesRaw[values[`${field}` as keyof typeof initialpersonal].toLowerCase()])
		return (<>
			{editMode ? <SelectCountry field={field} value={countries_.getCountryName(values['billing_country'])} setter={(c) => setValues({ ...values, billing_country: c })} />
				:
				<h6 className="text-[16px]">{countries_.getCountryName(values['billing_country'])}</h6>
			} 
		</>
		)
	}


	//handle file change
	const handlefilechange = (event: ChangeEvent<HTMLInputElement>) => {
		event.preventDefault();
		
		if (event.target.files) {
			console.log({ target: event.target.files[0] })
			setFileState({ file: event.target.files[0] }, 'file');
      
			let imageFile = event.target.files[0];
			if (imageFile) {
				const localImageUrl = URL.createObjectURL(imageFile);
        
				setFileState({ imageSrc: localImageUrl }, 'image')
			}
		}
		

		
	};



	return (
		<div id="personal_tab">
			<Card className="w-[717px] animate-bounced ">
				<div className="flex justify-between">
					<h1 className="font-semibold text-xl">Personal Information</h1>
					<button onClick={() => editClick()} className="w-[66px] h-[38px]  hover:bg-[#A87C51] hover:ease-linear hover:text-white font-bold text-[14px] rounded-[20px] bordered border-[1px] border-color-[#9D9D9D] bg-transparent">{titleEdit}</button>
				</div>

				<div className="flex gap-6 mt-8">
					<img src={fileState.imageSrc as string} className="h-[84px] w-[84px] rounded-full" />
					<div className="mt-2">
						<h5 className="text-[14px] font-semibold">Profile picture</h5>
						<input ref={fileref} type="file" onChange={(e) => handlefilechange(e)} hidden accept="image/png, image/gif, image/jpeg" />
						<button className={clsx("bg-transparent w-[92px] h-[38px] mt-[10px] mr-[23px] hover:bg-[#A87C51] hover:ease-linear hover:text-white font-semibold text-[14px] rounded-[20px] bordered border-[1px] border-color-[#9D9D9D]", { 'text-[#8c8c8c]': !editMode })} disabled={!editMode} onClick={() => { if (editMode) fileref.current?.click() }}>Change </button>
					</div>
				</div>

				<div className="grid grid-cols-2 w-[60%] mt-6 gap-4">
					<div>
						<h6 className="text-[14px] text-[#8C8C8C]">First name</h6>
						{InputText({ field: "first_name" })}
						
					
					</div>

					<div>
						<h6 className="text-[14px] text-[#8C8C8C]">Last name</h6>
						{InputText({ field: "last_name" })}
					</div>

					<div>
						<h6 className="text-[14px] text-[#8C8C8C]">Country/region</h6>
						{InputCountry({ field: "billing_country" })}
					</div>

					<div>
						<h6 className="text-[14px] text-[#8C8C8C]">Phone number</h6>
						{InputText({ field: "billing_phone" })}
						
					</div>

					<div>
						<h6 className="text-[14px] text-[#8C8C8C]">Town city</h6>
						{InputText({ field: "billing_city" })}
						
					</div>

					<div>
						<h6 className="text-[14px] text-[#8C8C8C]">Email address</h6>
						{InputText({ field: "billing_email" })}
						
					</div>
				</div>

				<div className="flex justify-between items-center mt-12">
					<h5 className="text-[14px] font-bold ">Address</h5>
					{/*<button className="bg-transparent w-[124px] h-[30px]   hover:bg-[#A87C51] hover:ease-linear hover:text-white  text-[14px] rounded-[20px] bordered border-[1px] border-color-[#9D9D9D]">Add address</button>*/}
				</div>
				<div className="mt-4 w-[661px] border-b-[1px] border-[#C7C7C7]"></div>
				{InputAddress({ field: "billing_address_1" })}
			</Card>
		</div>
	)
}

export function Booking() {
	return (<Card className="min-w-[778px]">
		<BookingContent />
	</Card>)
}

export function Payment() {
	return (<Card className="w-[717px]">
		<h1 className="font-semibold text-xl">Payment</h1>
	</Card>)
}

export function Logout() {
	return (<Card className="w-[717px]">
		<h1 className="font-semibold text-xl">Logout</h1>
	</Card>)
}