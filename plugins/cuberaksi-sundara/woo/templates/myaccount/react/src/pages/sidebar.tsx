import classNames from "classnames"
import { useState } from "react"
import { MenuItemConstant } from "../store"
import { useNavigate } from "react-router-dom"
import { ILayoutPage } from "./layout"
import Select, { components, ControlProps, SingleValue } from "react-select"

type IMenuItem = {
	active: boolean,
	icon: string,
	title: string,
	onClick: () => void
}

const myaccountobj =(window as any).myaccountobj
console.log({myaccountobj})
const menu = [
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/account.svg',
		title: 'Personal Information',
		label: 'Personal Information',
		value: 'personal',
		active: true,
	},
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/booking.svg',
		title: 'Bookings',
		label: 'Bookings',
		value: 'bookings',
		active: false,
	},
	// {
	// 	icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/payment.svg',
	// 	title: 'Payments',
	// 	active: false,
	// },
	{
		icon: 'https://sundaratravelclub.com/wp-content/plugins/cuberaksi-sundara/woo/templates/myaccount/dist/logout.svg',
		title: <span>Click <a className="text-[#BEB29A]" href={myaccountobj.url_logout}>here</a> to logout'</span>,
		label: 'Click here to logout',
		value: 'logout',
		active: false,
	},

]

const { Option } = components;
const IconOption = (props: any) => (
	<Option {...props}>
		<div className="flex gap-4">
			<img
				src={props.data.icon}
				style={{ width: 15 }}
				alt={props.data.label}
			/>
			{props.data.label}
		</div>
	</Option>
);
const Control = ({ children, ...props }: ControlProps) => {
	// @ts-ignore
	const { value }: { value: typeof menu[0] } = props.selectProps;
	// const style = { cursor: 'pointer' };
	// console.log({ props })
	return (
		<components.Control {...props}>
			<img
				className="mx-2 "
				src={value.icon}
				style={{ width: 15 }}
				
			/>
			{children}
		</components.Control>
	);
};

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

function SelectMenu() {
	return (<Select />)
}

export default function Sidebar({ page }: ILayoutPage) {
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
		// if (index + 1 === MenuItemConstant.payment) navigate('/payments')
		if (index + 1 === MenuItemConstant.logout) {
			// navigate('/logout')	
		}
	}

	const gomenu = (val: any) => {
		if (val.value === 'personal') navigate('/')
		if (val.value === 'bookings') navigate('/bookings')
		if (val.value === 'logout') {
			location.href = myaccountobj.url_logout
		}
	}

	return (

		<>
			<div className="flex flex-col gap-4">
				<h2 className="font-extrabold text-[38px]">My Account</h2>
				<div className="md:w-[298px] border-b-[1px] border-gray-950 opacity-[40%]"></div>
				<div className="hidden md:block flex flex-col content-center">
					{
						activelist.map((itm, idx) => {
							return <Menuitem key={idx} onClick={() => chgActive(idx)} active={itm.active} icon={itm.icon} title={itm.title as any} />
						})
					}
				</div>

				<div className="md:hidden flex flex-col content-center">
					<Select options={menu} defaultValue={menu[0]} onChange={(val) => gomenu(val)} components={{ Option: IconOption, Control } as any} classNames={{
						control: (state) => 'rounded-full pl-16',
					}}  theme={(theme) => ({
						...theme,
						borderRadius: 0,
						colors: {
						  ...theme.colors,
						  primary25: '#f5eeeb',
						  primary: '#c0b299',
						},
					  })} />
				</div>

			</div>
		</>
			
	)
}