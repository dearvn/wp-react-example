/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import {Routes, Route, useNavigate} from 'react-router-dom';
import JobCreate from './JobCreate';
import Table, { AvatarCell, SelectColumnFilter, StatusPill } from './Table';

const JobsPage = () => {
    const navigate = useNavigate();

    const url = wpApiSettings.root + 'job-place/v1/jobs';
    const [jobs, setJobs] = React.useState([]);

    React.useEffect(() => {
        async function loadJobs() {
            const response = await fetch(url, {
                headers : {
                    'X-WP-Nonce' : wpApiSettings.nonce
                }
            });
            if(!response.ok) {
                // oups! something went wrong
                console.log("something wrong");
                return;
            }
    
            const jobs = await response.json();
            setJobs(jobs);
        }
    
        loadJobs();
    }, []);

    const columns = React.useMemo(() => [
        {
          Header: "Title",
          accessor: 'title',
        },
        {
          Header: "Status",
          accessor: 'status',
          Cell: StatusPill,
        },
        {
          Header: "Type",
          accessor: 'job_type',
          Filter: SelectColumnFilter,
          filter: 'includes',
        },
      ], []);

      const navigateToCreate = () => {
            // 👇️ navigate to /
            navigate('/jobs-create');
        };
    return (
        
        <div className="dashboard">
            <div className="min-h-screen bg-gray-100 text-gray-900">
                <main className="mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div className="">
                    <h3 className="text-xl font-semibold">Jobs</h3>
                    </div>

                    <button onClick={navigateToCreate} class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add
                    </button>
                    <div className="mt-6">
                        <Table columns={columns} data={jobs} />
                    </div>
                </main>
            </div>
            
        </div>
    );
};

export default JobsPage;
