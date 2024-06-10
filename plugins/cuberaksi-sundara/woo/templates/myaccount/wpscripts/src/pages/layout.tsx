import { Outlet } from "react-router-dom";
import Sidebar from "./sidebar";

export default function Layout()
{
    return (<div className="flex flex-row gap-4 onest-font p-12">
    	<Sidebar />
    	<Outlet />
    	</div>)
}