import classNames from "classnames"
import { useState } from "react"
import { MenuItemConstant } from "../store"
import { useNavigate } from "react-router-dom"

type IMenuItem = {
	active: boolean,
	icon: string,
	title: string,
	onClick: () => void
}

const menu = [
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/account.svg',
		title: 'Personal Information',
		active: true,
	},
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/booking.svg',
		title: 'Bookings',
		active: false,
	},
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/payment.svg',
		title: 'Payments',
		active: false,
	},
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/logout.svg',
		title: 'Logout',
		active: false,
	},

]

function Menuitem({ active, icon, title, onClick }: IMenuItem) {
	return (<div onClick={() => onClick()} className={classNames("cursor-pointer h-[48px] flex items-center gap-4", { 'font-bold': active, 'text-[#8C8C8C]': !active, 'text-slate-950': active })}>
		
		<img className="w-4 text-blue-400" src={icon} />
		<div className="w-full items-center flex justify-between">
			{title} 
			<span className={classNames({ 'hidden': !active }, "w-2 h-2  rounded-full bg-[#A87C51]")}>
			
			</span>
		</div>
	</div>)
}
export default function Sidebar() {
	const [activelist, setActivelist] = useState(menu)
	const navigate = useNavigate()

	const chgActive = (index: number) => {

		setActivelist(activelist.map((itm, idx) => {
			itm.active = false
			if (idx === index) itm.active = true
			
			return itm
		}))

		if (index + 1 === MenuItemConstant.personal) navigate('/')
		if (index + 1 === MenuItemConstant.booking) navigate('/bookings')
		if (index + 1 === MenuItemConstant.payment) navigate('/payments')
		if (index + 1 === MenuItemConstant.logout) navigate('/logout')	
	}

	return (

		<>
			<div className="flex flex-col gap-4">
				<h2 className="font-extrabold text-[38px]">My Account</h2>
				<div className="w-[298px] border-b-[1px] border-gray-950 opacity-[40%]"></div>
				<div className="flex flex-col content-center">
					{
						activelist.map((itm, idx) => {
							return <Menuitem key={idx} onClick={() => chgActive(idx)} active={itm.active} icon={itm.icon} title={itm.title} />
						})
					}
				</div>
			</div>
		</>
			
	)
}