/**
 * Internal dependencies
 */
import HomePage from '../pages/HomePage';
import JobCreate from '../pages/JobCreate';
import JobsPage from '../pages/JobsPage';

const routes = [
	{
		path: '/',
		element: HomePage,
	},
	{
		path: '/jobs',
		element: JobsPage,
	},
	{
		path: '/jobs-create',
		element: JobCreate,
	}
	];

	export default routes;
