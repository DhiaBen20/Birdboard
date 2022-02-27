import { Head, usePage } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import {Input, Button, Label,} from "../../Components/lib";

function Register() {
    let {
        props: {
            errors: { name, email, password },
        },
    } = usePage();

    function handleSubmit(e) {
        e.preventDefault();

        let elements = e.target.elements;

        Inertia.post("/register", {
            name: elements.name.value,
            email: elements.email.value,
            password: elements.password.value,
            password_confirmation: elements.password_confirmation.value,
        });
    }

    return (
        <div className="flex w-full items-center justify-center">
            <Head title="Register" />
            <form
                className="w-full max-w-md rounded-md bg-white px-6 py-4 shadow-md"
                onSubmit={handleSubmit}
            >
                <div>
                    <Label htmlFor="name">Name</Label>
                    <Input name="name" id="name" />
                    {name && (
                        <span className="text-sm font-semibold text-red-500">
                            {name}
                        </span>
                    )}
                </div>

                <div className="mt-4">
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

                <div className="mt-4">
                    <Label htmlFor="password_confirmation">Password</Label>
                    <Input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                    />
                </div>

                <div className="mt-4 flex justify-end">
                    <Button>Register</Button>
                </div>
            </form>
        </div>
    );
}

export default Register;
