import { InitialRows, RowBookings } from "@/components/booking/rowbooking";
import { Button } from "@/components/ui/button"
import { ApiEndPointWith, fetchPostAjaxWith } from "@/helper";
import { useQuery } from "@tanstack/react-query";
import classNames from "classnames";
import { useState } from "react";

export default function BookingContent() {
	const [ActiveTab, setActiveTab] = useState('All')
	// const [initial, setInitial] = useState([])
	const { data: initial, isSuccess } = useQuery({
		queryKey: ['yith-booking',ActiveTab],
		queryFn: () => fetchPostAjaxWith('bookings', { status: ActiveTab }).then((res) => res.json())
		// queryFn: () => fetch('https://sundaratravelclub.com/wp-json/sundara/v1/bookings').then((res) => res.json())
	})

	// if (isSuccess) setActiveTab('Upcoming')

	const getCurrentActiveTabClass = (tab: string) => {
		let bg = ''
		if (tab === ActiveTab) bg = 'bg-[#BEB29A] text-white' 
		return bg
	}
	return (
		<>
			<h1 className="font-semibold text-xl">Bookings</h1>
			<div className="flex gap-4 my-4 mb-8 flex-wrap">

				<Button onClick={() => setActiveTab('All')} variant={'outline'} className={classNames("rounded-full hover:text-white  hover:bg-[#BEB29A] hover:text-bold border-[#9D9D9D]", getCurrentActiveTabClass('All'))} >All</Button>
				<Button onClick={() => setActiveTab('Unpaid')} variant={'outline'} className={classNames("hover:text-bold rounded-full hover:text-white  hover:bg-[#BEB29A] border-[#9D9D9D]", getCurrentActiveTabClass('Unpaid'))}>Unpaid</Button>
				<Button onClick={() => setActiveTab('Completed')} variant={'outline'} className={classNames("rounded-full hover:text-bold hover:text-white  hover:bg-[#BEB29A] border-[#9D9D9D]", getCurrentActiveTabClass('Completed'))}>Completed</Button>
				<Button onClick={() => setActiveTab('Cancelled')} variant={'outline'} className={classNames("rounded-full hover:text-white  hover:bg-[#BEB29A] hover:text-bold border-[#9D9D9D]", getCurrentActiveTabClass('Cancelled'))} >Cancelled</Button>
				<Button onClick={() => setActiveTab('Confirmed')} variant={'outline'} className={classNames("hover:text-bold rounded-full hover:text-white  hover:bg-[#BEB29A] border-[#9D9D9D]", getCurrentActiveTabClass('Confirmed'))}>Confirmed</Button>
				<Button onClick={() => setActiveTab('Rejected')} variant={'outline'} className={classNames("rounded-full hover:text-bold hover:text-white  hover:bg-[#BEB29A] border-[#9D9D9D]", getCurrentActiveTabClass('Rejected'))}>Rejected</Button>
			</div>
			<RowBookings section={ActiveTab} data={initial} /> 
			
		</>)
}