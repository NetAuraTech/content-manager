import {useUniqId} from "../../../../functions/hooks";
import {defineField} from "./utils";
import {Field} from "../ui/field";
import {JSX} from "preact";

export type ImageFieldArgs = {
    label?: string
    default?: string,
    canAnimate?: boolean
}

const Component: ({value, onChange, options}: { value: any; onChange: any; options: any }) => JSX.Element = ({
                                                          value,
                                                          onChange,
                                                          options,
                                                      }) => {
    const id = useUniqId('imageinput')

    return (
        <Field
            id={id}
            label={options.label}
            type="image"
            value={value}
            onInput={e => onChange((e.target as HTMLInputElement).value)}
        />
    )
}

export const Image = defineField<ImageFieldArgs, string>({
    defaultOptions: {
        default: '',
        canAnimate: false
    },
    render: Component,
})
