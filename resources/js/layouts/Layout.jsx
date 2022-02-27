import Navbar from "../Components/Navbar";

function Layout(page) {
    return (
        <div className="flex flex-col min-h-screen">
            <Navbar />

            <div className="flex-1 grid grid-cols-4">
                <div className="col-span-3 pl-10">{page}</div>
                <div className="col-span-1 bg-[#f9f9fb]"></div>
            </div>
        </div>
    );
}

export default Layout;
