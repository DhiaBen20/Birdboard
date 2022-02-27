import { useForm } from "@inertiajs/inertia-react";
import { useEffect, useState } from "react";
import { Spinner } from "./lib";

function CompleteTask({ task }) {
    let [completed, setCompleted] = useState(!!task.completed);
    let { data, setData, isDirty, patch, processing } = useForm();

    useEffect(() => {
        if (isDirty) {
            patch(`/projects/${task.project_id}/tasks/${task.id}`, {
                onSuccess: () => setCompleted((state) => !state),
            });
        }
    }, [data]);

    function handleClick() {
        setData("completed", !completed);
    }

    return (
        <div
            className="relative flex h-[23px] w-[23px] items-center justify-center"
            onClick={handleClick}
        >
            {processing ? (
                <Spinner />
            ) : (
                <div className="cursor-pointer select-none">
                    <span
                        className={`absolute inset-0 rounded border-2 ${
                            completed ? "border-[#aae9fa]" : ""
                        }`}
                    />
                    {completed && (
                        <img
                            src="/images/checkbox-feather.png"
                            draggable={false}
                            className="absolute left-1 bottom-1 h-7 w-7"
                        />
                    )}
                </div>
            )}
        </div>
    );
}

// function CompleteTask({ task }) {
//     let [completed, setCompleted] = useState(!!task.completed);
//     let { data, setData, isDirty, patch, processing } = useForm();

//     useEffect(() => {
//         if (isDirty) {
//             patch(`/projects/${task.project_id}/tasks/${task.id}`, {
//                 onSuccess: () => setCompleted((state) => !state),
//             });
//         }
//     }, [data]);

//     function handleClick() {
//         setData("completed", !completed);
//     }

//     return (
//         <>
//             {processing ? (
//                 <div className="mt-1 mr-1">
//                     <Spinner />
//                 </div>
//             ) : (
//                 <div
//                     className="relative w-7 h-7 select-none cursor-pointer"
//                     onClick={handleClick}
//                 >
//                     <span
//                         className={`absolute bottom-0 left-0 border-2 rounded w-[23px] h-[23px] ${
//                             completed ? "border-[#aae9fa]" : ""
//                         }`}
//                     ></span>
//                     {completed && (
//                         <img
//                             src="/images/checkbox-feather.png"
//                             draggable={false}
//                             className="absolute w-6 h-6 left-1"
//                         />
//                     )}
//                 </div>
//             )}
//         </>
//     );
// }

export default CompleteTask;
