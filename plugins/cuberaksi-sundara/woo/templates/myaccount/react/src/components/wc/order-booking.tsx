type IOrderRowbookingElement = {
	image: string,
	title: string,
	from: string,
	to: string,
	persons: string,
	price: string,
}


export function OrderRowbookingElement(data: IOrderRowbookingElement) {
	const priceDetail = Number(data.price) / Number(data.persons)
	return (<>
		<div className="flex flex-row gap-4 my-4 mt-4">
			<img src={data.image} className="w-20 h-20 rounded-xl" />

			<div className="flex flex-row w-full">
				<div className="flex flex-col gap-2 w-2/3">
					<h3 className="text-xl font-[600] leading-6 mb-0">{data.title}</h3>
					<div className="flex flex-row gap-4 justify-between">
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
							<div className="text-[16px] text-[#C7C7C7]">Pax</div>
							<div className="text-lg font-[500] text-black leading-6">{data.persons} persons</div>
						</div>
					</div>	
				</div>

				<div className="flex flex-col gap-4 w-1/3">
					<h4 className="flex justify-end font-semibold text-2xl text-[600] text-[#A87C51]">$ {new Intl.NumberFormat('en-US').format(Number(data.price))}</h4>
					<div className="flex gap-4 flex-row-reverse">
						@ $ {new Intl.NumberFormat('en-US').format(priceDetail)} x {data.persons}
					
					</div>
				</div>

			</div>
		</div>
		<div className="flex w-full bordered border-gray border-b-2 mb-4"></div>
	</>
	)
}