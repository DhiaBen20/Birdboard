import { useForm } from "@inertiajs/inertia-react";
import { useEffect, useRef, useState } from "react";
import { Button, Spinner } from "./lib";

function GeneralNotes({ project }) {
    let [editing, setEditing] = useState(false);
    let [notes, setNotes] = useState(project.notes ?? "");
    let textareaRef = useRef();
    let { data, setData, patch, processing, isDirty } = useForm();

    useEffect(() => {
        if (isDirty) {
            patch(`/projects/${project.id}`, {
                onSuccess: () => setEditing(false),
            });
        }
    }, [data]);

    useEffect(() => {
        if (editing) {
            textareaRef.current.selectionStart = notes.length;
            textareaRef.current.selectionEnd = notes.length;
            textareaRef.current.focus();
        }
    }, [editing]);

    function handleSubmit(e) {
        e.preventDefault();
        setData("notes", e.target.elements.notes.value);
    }

    function handleCancel() {
        setEditing(false);
        setNotes(project.notes);
    }

    return (
        <>
            <div className="mt-8 flex items-center justify-between">
                <h3 className="mb-2 text-lg text-gray-600">General Notes</h3>

                {processing && <Spinner />}
            </div>

            {editing ? (
                <form onSubmit={handleSubmit}>
                    <textarea
                        name="notes"
                        className="min-h-[200px] w-full rounded-md border-0 bg-white p-4 shadow"
                        value={notes}
                        onChange={(e) => setNotes(e.target.value)}
                        ref={textareaRef}
                    />
                    <div className="mt-3 flex select-none justify-end space-x-2">
                        <Button
                            type="button"
                            onClick={handleCancel}
                            variant="muted"
                            disabled={processing}
                        >
                            Cancel
                        </Button>
                        <Button disabled={processing}>Update</Button>
                    </div>
                </form>
            ) : (
                <div
                    className="min-h-[200px] select-none rounded-md bg-white p-4 shadow"
                    onDoubleClick={() => setEditing(true)}
                >
                    {notes}
                </div>
            )}
        </>
    );
}

export default GeneralNotes;
