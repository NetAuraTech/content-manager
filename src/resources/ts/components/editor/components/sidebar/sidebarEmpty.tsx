import {translate} from "@core-cms-shared/functions/i18n";
import {prevent} from "@core-cms-shared/functions/functions";


type Props = {
  onAction: Function
}

export function SidebarEmpty(data: Props) {

    return (
        <div className='editor__sidebar-empty'>
            <p>{translate('content-manager.admin.editor.sidebar.empty')}</p>
            <div>
                <button
                    className="button"
                    data-type="primary"
                    onClick={prevent(data.onAction)}
                >
                    {translate('content-manager.admin.editor.sidebar.component.all')}
                </button>
            </div>
        </div>
    )
}
