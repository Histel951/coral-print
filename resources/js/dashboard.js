import FileManagerController from './controllers/file-manager';
import FileManagerModalController from './controllers/file-manager-modal';
import FileManagerSelectorController from './controllers/file-manager-selector';
import TurboHandlerController from './controllers/turbo-handle_controller';
import SpanController from './controllers/span_controller';
import CheckboxChangeableController from "./controllers/checkbox-changeable_controller";
import ClearPictureController from "./controllers/clear-picture_controller";
import SelectTableController from "./controllers/select-table_controller";
import Ckeditor_controller from './controllers/ckeditor_controller';

application.register('file-manager', FileManagerController);
application.register('file-manager-modal', FileManagerModalController);
application.register('file-manager-selector', FileManagerSelectorController);
application.register('turboHandle', TurboHandlerController);
application.register('spanController', SpanController);
application.register('checkboxChangeable', CheckboxChangeableController);
application.register('clearPicture', ClearPictureController);
application.register('selectTable', SelectTableController);
application.register("ckeditor", Ckeditor_controller);
