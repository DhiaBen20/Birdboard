import { Head, usePage } from "@inertiajs/inertia-react";
import {Input, Textarea, Label, Button} from "../../Components/lib";

function Create() {
    let {
        props: {
            errors: { title, description },
        },
    } = usePage();

    function handleSubmit() {}

    return (
        <div className="flex w-full items-center justify-center">
            <Head title="Login" />
            <form
                className="w-full max-w-md rounded-md bg-white px-6 py-4 shadow-md"
                onSubmit={handleSubmit}
            >
                <div>
                    <Label htmlFor="title">Title</Label>
                    <Input name="title" id="title" />
                    {title && (
                        <span className="text-sm font-semibold text-red-500">
                            {title}
                        </span>
                    )}
                </div>

                <div className="mt-4">
                    <Label htmlFor="description">Description</Label>
                    <Textarea name="description" id="description"></Textarea>
                    {description && (
                        <span className="text-sm font-semibold text-red-500">
                            {description}
                        </span>
                    )}
                </div>

                <div className="mt-4 flex justify-end">
                    <Button>Create</Button>
                </div>
            </form>
        </div>
    );
}

export default Create;
