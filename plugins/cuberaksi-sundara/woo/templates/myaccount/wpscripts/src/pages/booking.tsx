import { InitialRows, RowBookings } from "@/components/booking/rowbooking";
import { Button } from "@/components/ui/button"
import classNames from "classnames";
import { useState } from "react";

export default function BookingContent() {
	const [ActiveTab, setActiveTab] = useState('Upcoming')
	const [initial, setInitial] = useState(InitialRows)
 
	const getCurrentActiveTabClass = (tab: string) => {
		let bg = ''
		if (tab === ActiveTab) bg = 'bg-[#BEB29A] text-white' 
		return bg
	}
	return (
		<>
			<h1 className="font-semibold text-xl">Bookings</h1>
			<div className="flex gap-4 my-4 mb-8">
				<Button onClick={() => setActiveTab('Process')} variant={'outline'} className={classNames("rounded-full hover:text-white  hover:bg-[#BEB29A] hover:text-bold border-[#9D9D9D]", getCurrentActiveTabClass('Process'))} >Process</Button>
				<Button onClick={() => setActiveTab('Upcoming')} variant={'outline'} className={classNames("hover:text-bold rounded-full hover:text-white  hover:bg-[#BEB29A] border-[#9D9D9D]", getCurrentActiveTabClass('Upcoming'))}>Upcoming</Button>
				<Button onClick={() => setActiveTab('Past')} variant={'outline'} className={classNames("rounded-full hover:text-bold hover:text-white  hover:bg-[#BEB29A] border-[#9D9D9D]", getCurrentActiveTabClass('Past'))}>Past</Button>
			</div>

			<RowBookings section={ActiveTab} data={initial} />

		</>)
}