import { useState } from "react"
import { Button } from "../ui/button"
import classNames from "classnames"

type TRowBookings = {
	section?: 'Process' | 'Upcoming' | 'Past' | string,
	data?: Array<any>,
	item?: any
}

const imgsrc = 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/wisata.png'
const vietsrc = 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/vietnam.png'
const balisrc = 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/bali.png'
const thaisrc = 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/thailand.png'
const infosvg = 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/info.svg'

export const InitialRows = [
	{
		title: 'Vietnam 12 Days Trip',
		image: imgsrc,
		from: 'Mar 9, 2024', 
		to: 'Mar 20, 2024',
		persons: 2,
		price: '$ 20,200',
		section: 'Upcoming'
	},
	{
		title: 'Vietnam 8 Days Trip',
		image: vietsrc,
		from: 'Mar 9, 2024', 
		to: 'Mar 20, 2024',
		persons: 2,
		price: '$ 20,200',
		section: 'Process',
		status: 'Hold',
	},
	{
		title: 'Bali 20 Days Trip',
		image: balisrc,
		from: 'Mar 9, 2024', 
		to: 'Mar 20, 2024',
		persons: 2,
		price: '$ 20,200',
		section: 'Process',
		status: 'Paid',
	},
	{
		title: 'Thailand 7 Days Trip',
		image: thaisrc,
		from: 'Mar 9, 2024', 
		to: 'Mar 20, 2024',
		persons: 2,
		price: '$ 20,200',
		section: 'Process',
		status: 'Failed',
	},

]

export function RowBookings({ section, data }: TRowBookings) {
	return (
		<>
			{data && data.filter((flt) => flt.section === section).length > 0 ? data.filter((flt) => flt.section === section).map((row, idx) => {
				
				return <RowBooking key={row.title} item={row} section={section} />
			}) : <h1>I'm sorry. No bookings data yet..</h1>}
		</>
	)
	
}

export function RowBooking({ item, section }: TRowBookings) {
	const [data] = useState(item)
	const infoClick = () => {}
	const cancelClick = () => {}

	const Content = () => {
		if (section === 'Upcoming') return <UpcomingContent />
		if (section === 'Process') return <ProcessContent />
	}
	const UpcomingContent = () => {
		return (<>
			<img onClick={() => infoClick()} src={infosvg} />
			<Button onClick={() => cancelClick()} variant={"outline"} className="rounded-full border-red-600 text-red-600 hover:bg-red-400 hover:text-white hover:font-bold">Cancel</Button>
		</>)
	}

	const ProcessContent = () => {
		const paid = 'border-yellow-600 bg-yellow-600 text-yellow-600 text-white hover:font-bold'
		const hold = 'border-green-600 bg-red-600 text-green-600 text-white hover:font-bold'
		const failed = 'border-red-600 bg-red-600 text-red-600 text-white hover:font-bold'

		const getStatusClass = (status: string) => {
			if (status === 'Hold') return hold
			if (status === 'Paid') return paid
			if (status === 'Failed') return failed	
		}

		return (<>
			<Button className={classNames("rounded-full", getStatusClass(item.status))}>{item.status}</Button>
		</>)
	}

	return (<>
		<div className="flex flex-row gap-4 my-4 mt-4">
			<img src={data.image} className="w-20 h-20 rounded-xl" />

			<div className="flex flex-col gap-2">
				<h3 className="text-xl font-[600] leading-6">{data.title}</h3>
				<div className="flex flex-row gap-4">
					<div>
						<div className="text-[16px] text-[#C7C7C7]">From</div>
						<div className="text-lg font-[500] text-black leading-6">{data.from}</div>	
					</div>

					<div>
						<div className="text-[16px] text-[#C7C7C7]">To</div>
						<div className="text-lg font-[500] text-black leading-6">{data.to}</div>
					</div>

					<div className="border-l-2 w-2 bordered">
				 	   	
					</div>

					<div>
						<div className="text-[16px] text-[#C7C7C7]">How many</div>
						<div className="text-lg font-[500] text-black leading-6">{data.persons} persons</div>
					</div>
				</div>	
			</div>

			<div className="flex flex-col gap-4 w-60">
				<h4 className="flex justify-end font-semibold text-2xl text-[600] text-[#A87C51]">{data.price}</h4>
				<div className="flex gap-4 flex-row-reverse">
					<Content />
					
				</div>
			</div>
		</div>
		<div className="flex w-full bordered border-gray border-b-2 mb-8"></div>
	</>
	)
}