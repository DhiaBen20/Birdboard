import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/inertia-react";
import { Input, Button, Label } from "../../Components/lib";

function Login() {
    let {
        props: {
            errors: { email, password },
        },
    } = usePage();

    function handleSubmit(e) {
        e.preventDefault();

        let elements = e.target.elements;

        Inertia.post("/login", {
            email: elements.email.value,
            password: elements.password.value,
        });
    }

    return (
        <div className="flex w-full items-center justify-center">
            <Head title="Login" />
            <form
                className="w-full max-w-md rounded-md bg-white px-6 py-4 shadow-md"
                onSubmit={handleSubmit}
            >
                <div>
                    <Label htmlFor="email">Email</Label>
                    <Input type="email" name="email" id="email" />
                    {email && (
                        <span className="text-sm font-semibold text-red-500">
                            {email}
                        </span>
                    )}
                </div>

                <div className="mt-4">
                    <Label htmlFor="password">Password</Label>
                    <Input type="password" name="password" id="password" />
                    {password && (
                        <span className="text-sm font-semibold text-red-500">
                            {password}
                        </span>
                    )}
                </div>

                <div className="mt-4 flex justify-end">
                    <Button>Login</Button>
                </div>
            </form>
        </div>
    );
}

export default Login;
