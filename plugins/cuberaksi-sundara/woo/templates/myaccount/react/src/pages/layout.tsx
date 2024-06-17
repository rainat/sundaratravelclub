import { Outlet } from "react-router-dom";
import Sidebar from "./sidebar";

export type ILayoutPage = {
    page?: string
}
export default function Layout({ page }: ILayoutPage) {
    return (<div className="flex flex-col md:flex-row gap-4 onest-font md:p-12">
        <Sidebar page={page} /> 
        <Outlet />
    </div>)
}