import { Link, usePage } from "@inertiajs/inertia-react";
import { NavLink } from "./lib";

function Navbar() {
    let {
        component,
        props: { auth },
    } = usePage();

    return (
        <nav className="flex h-16 justify-between border-b border-gray-300 bg-white px-10">
            <div className="flex items-center">
                <Link href="/" className="text-lg font-bold">
                    <img
                        src="/images/logo.png"
                        alt="Birdboard Logo"
                        className="h-8"
                    />
                </Link>
            </div>

            <div className="flex items-center space-x-6">
                {auth && (
                    <>
                        <NavLink href="/logout" as="button" method="post">
                            Logout
                        </NavLink>
                    </>
                )}
                {!auth && (
                    <>
                        <NavLink
                            href="/register"
                            active={component === "Auth/Register"}
                        >
                            Register
                        </NavLink>
                        <NavLink
                            href="/login"
                            active={component === "Auth/Login"}
                        >
                            Login
                        </NavLink>
                    </>
                )}
            </div>
        </nav>
    );
}

export default Navbar;
